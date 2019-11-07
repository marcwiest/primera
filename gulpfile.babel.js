
const { src, dest, watch, series, parallel } = require('gulp');

const fs             = require('fs');
const path           = require('path');
const autoprefixer   = require('autoprefixer');
const browsersync    = require('browser-sync').create();
const cssnano        = require('cssnano');
const gulpif         = require('gulp-if');
const imagemin       = require('gulp-imagemin');
const plumber        = require('gulp-plumber');
const postcss        = require('gulp-postcss');
const customProps    = require('postcss-custom-properties');
const rename         = require('gulp-rename');
const replace        = require('gulp-replace');
const sass           = require('gulp-sass');
const sassglob       = require('gulp-sass-glob');
const sourcemaps     = require('gulp-sourcemaps');
const tailwindcss    = require('tailwindcss');
const uglify         = require('gulp-uglify');
const wppot          = require('gulp-wp-pot');
const mozjpeg        = require('imagemin-mozjpeg');
const pngquant       = require('imagemin-pngquant');
const notifier       = require("node-notifier");
const easings        = require('postcss-easings');
const rollup         = require('rollup');
const rollupBabel    = require('rollup-plugin-babel');
const rollupCommonjs = require('rollup-plugin-commonjs');
const rollupUglify   = require('rollup-plugin-uglify-es');
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
                    // rollupUglify(),
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
    })
}

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
            // tailwindcss('./tailwind.js'),
            tailwindcss(),
            customProps(), // adds fallback for custom props
            autoprefixer(),
            // easings(),
            // cssnano({ zindex : false })
        ]))
        // .pipe(gulp.dest(config.destFolder))
        // .pipe(rename({ extname : '.min.css' }))
        .pipe(sourcemaps.write('./'))
        .pipe(dest(config.destFolder))
        .pipe(browsersync.stream());

    done();
}


/**
* Create translation (POT) file for WordPress.
*/
const createPotFile = done => {

    const config = {
        textdomain: 'primera',
    };

    src('**/*.php')
        .pipe(wppot({ domain : config.textdomain }))
        .pipe(dest('./languages/' + config.textdomain + '.pot'));

    done();
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
        // reloadDelay: 500, // discourse.roots.io/t/sage-9-browsersync-not-updating-right/10648/9
        // injectChanges: false, // issues a full refresh
        files: [
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
    // NOTE: PHP reload seams not needed.
    // watch(['source/views/**/**/*.php'], reloadBrowser)
}

exports.develop = series(
    parallel(bundleScss, bundleJs),
    parallel(initBrowserSync, watchFiles),
    reloadBrowser
)

// exports.build = series(
//     // minify scripts
//     // shift off dev files
//     // bundle zip files
// )

// exports.deploy = series(
//     // push to git branch that deploys to server
// )

exports.default = exports.develop
