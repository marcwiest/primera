
const { src, dest, watch, series, parallel } = require('gulp');

const fs             = require('fs');
const path           = require('path');
const archiver       = require('archiver');
const autoprefixer   = require('autoprefixer');
const browsersync    = require('browser-sync').create();
const cssnano        = require('cssnano');
// const gulpif         = require('gulp-if');
// const imagemin       = require('gulp-imagemin');
const plumber        = require('gulp-plumber');
const postcss        = require('gulp-postcss');
const rename         = require('gulp-rename');
// const replace        = require('gulp-replace');
const sass           = require('gulp-sass');
const sassglob       = require('gulp-sass-glob');
const sourcemaps     = require('gulp-sourcemaps');
const tailwindcss    = require('tailwindcss');
const uglify         = require('gulp-uglify');
const wppot          = require('gulp-wp-pot');
// const mozjpeg        = require('imagemin-mozjpeg');
// const pngquant       = require('imagemin-pngquant');
const notifier       = require("node-notifier");
const ora            = require('ora');
const customProps    = require('postcss-custom-properties');
// const easings        = require('postcss-easings');
const rimraf         = require("rimraf");
const rollup         = require('rollup');
const rollupBabel    = require('rollup-plugin-babel');
const rollupCommonjs = require('rollup-plugin-commonjs');
// const rollupUglify   = require('rollup-plugin-uglify-es');
const rollupResolveNodeModules = require('rollup-plugin-node-resolve');

/**
* Process JS.
*/
const bundleJs = done => {

    fs.readdirSync('./source/js').forEach(file => {

        // Skip files begining with underscores.
        if ( file.indexOf('_') === 0 ) {
            return;
        }

        let ext = path.extname(file);

        if ( ext === '.js' || ext === '.jsx' || ext === '.es' ) {

            rollup.rollup({
                input: `./source/js/${file}`,
                plugins: [
                    rollupResolveNodeModules(),
                    rollupCommonjs(),
                    rollupBabel(),
                ],
            })
            .then(bundle => {
                return bundle.write({
                    file: `./public/js/${file}`,
                    format: 'iife',
                    sourcemap: true,
                })
            })
            .catch(error => {
                let relativePath = path.relative(process.cwd(), error.loc.file)
                notifier.notify({
                    title: `JS Error`,
                    message: `${relativePath} line ${error.raisedAt}`,
                })
                console.error(error)
            });
        }

        browsersync.stream();
        done();
    });
};

/**
* Process CSS.
*/
const bundleScss = done => {

    const config = {
        sourceFiles : ['./source/scss/*.scss'],
        destFolder: './public/css',
    };

    src(config.sourceFiles)
        .pipe(plumber({
            errorHandler: error => {
                notifier.notify({
                    title: `SCSS Error`,
                    message: `${error.relativePath} line ${error.line}`,
                })
                console.error(error)
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sassglob())
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(postcss([
            tailwindcss(), // tailwindcss('./tailwind.js'),
            customProps(), // adds fallback for custom props
            autoprefixer(),
            // easings(),
        ]))
        .pipe(sourcemaps.write('./'))
        .pipe(dest(config.destFolder))
        .pipe(browsersync.stream());

    done();
};

const minifyJs = () => {

    let config = {
        sourceFiles : [
            './public/js/*.js',
            // '!./public/js/*.min.js',
        ],
        destFolder: 'public/js/',
        uglifyOpt: {},
        renameOpt: {
            // extname: '.min.js'
        },
    };

    // NOTE: This stream needs to return so that tasks that follow know when this task is done.
    return src(config.sourceFiles)
        .pipe(uglify(config.uglifyOpt))
        .pipe(rename(config.renameOpt))
        .pipe(dest(config.destFolder));
};

const minifyCss = () => {

    let config = {
        sourceFiles : [
            './public/css/*.css',
            // '!./public/css/*.min.css',
        ],
        destFolder: 'public/css/',
        cssnanoOpt: {
            zindex: false
        },
        renameOpt: {
            // extname: '.min.css'
        },
    };

    // NOTE: This stream needs to return so that tasks that follow know when this task is done.
    return src(config.sourceFiles)
        .pipe(postcss([
            cssnano(config.cssnanoOpt)
        ]))
        .pipe(rename(config.renameOpt))
        .pipe(dest(config.destFolder));
};

/**
* Create translation (POT) file for WordPress.
*/
const createPotFile = () => {

    const config = {
        sourceFiles: [
            "./app/**/*.php",
            "./source/views/**/**/*.php",
        ],
        destFolder: './languages',
        textdomain: 'primera',
    };

    // NOTE: This stream needs to return so that tasks that follow know when this task is done.
    return src(config.sourceFiles)
        .pipe(wppot({ domain: config.textdomain }))
        .pipe(dest(config.destFolder + '/' + config.textdomain + '.pot'));
};

/**
* Create zip file of theme.
*
* TODO: Add version param: https://www.sitepoint.com/pass-parameters-gulp-tasks/
*/
const createZipFile = done => {

    let config = {
        zipFilePath: __dirname + '/builds',
        zipFileName: 'primera',
        ignoreFiles: [
            'builds/**', // exclude self
            '.git/**',
            'node_modules/**',
            'source/scss/**',
            'source/js/**',
            '**/*.zip',
            '**/*.map',
            '.babelrc',
            '.gitignore',
            'gulpfile.babel.js',
            'package-lock.json',
            'package.json',
            'tailwind.config.js',
        ],
    };

    if (! fs.existsSync(config.zipFilePath)) {
        fs.mkdirSync(config.zipFilePath);
    }

    let output  = fs.createWriteStream(config.zipFilePath + `/${config.zipFileName}.zip`),
        archive = archiver('zip'),
        spinner = ora();

    output.on('pipe', function() {
        spinner.text = 'Please wait while the project is being zipped.';
        spinner.start();
    });

    output.on('close', function () {

        spinner.stop();
        console.log(`The file "${config.zipFileName}.zip" is now ready.`);

        rimraf.sync('./languages/');
        // NOTE: Remove rimraf in favor of the below starting with node version 12.10.
        // fs.rmdirSync('./languages/', {
        //     recursive: true,
        // });

        done();
    });

    archive.on('error', function(err) {
        throw err;
    });

    archive.pipe(output);
    archive.glob('**', {
        dot: true, // include dot files like .htaccess
        ignore: config.ignoreFiles,
    });

    archive.finalize();

    // NOTE: `done()` called via `output.on('close', …)`.
};

/**
* Initialize BrowserSync and it's PHP server.
*/
const initBrowserSync = done => {

    // browsersync.io/docs/options
    const config = {
        watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
        proxy: 'primera',
        tunnel: false, // string|bool
        notify: false,
        open: false,
        files: [
            // NOTE: Excluding CSS maps seems to solve the CSS injection issue.
            // Source: https://stackoverflow.com/a/36003566
            "!/public/css/*.maps.css",
            "./app/**/*.php",
            "./source/views/**/**/*.php",
            "./public/css/**/*.css",
            "./public/js/**/*.js",
            "./public/img/**/*",
        ],
    };
    browsersync.init(config);
    done();
}

/**
* Causes BrowserSync to do full window refresh.
*/
const reloadBrowser = done => {
    browsersync.reload();
    done();
}

/**
* Watch task.
*
* The paths must be absolute (not realtive ./) for newly added files to be recognized during watch.
* https://github.com/sindresorhus/gulp-ruby-sass/issues/11#issuecomment-33660887
*/
const watchFiles = () => {

    watch('source/js/**/*.js', bundleJs)
    watch('source/scss/**/*.scss', bundleScss)
    // NOTE: PHP files need a solid reload, for CSS & JS to reflect the lastet changes.
    // NOTE: PHP reload seems not needed.
    // watch(['source/views/**/**/*.php'], reloadBrowser)
}

exports.develop = series(
    parallel(bundleScss, bundleJs),
    parallel(initBrowserSync, watchFiles),
    reloadBrowser
)

exports.build = series(
    parallel(bundleScss, bundleJs),
    parallel(minifyCss, minifyJs),
    createPotFile,
    createZipFile
)

// exports.deploy = series(
//     // push to git branch that deploys to server
// )

exports.default = exports.develop
