
const { src, dest, watch, series, parallel } = require('gulp');

const fs             = require('fs');
const path           = require('path');
const autoprefixer   = require('autoprefixer');
const browsersync    = require('browser-sync').create();
const mqpacker       = require('css-mqpacker');
const cssnano        = require('cssnano');
const gulpif         = require('gulp-if');
const imagemin       = require('gulp-imagemin');
const plumber        = require('gulp-plumber');
const postcss        = require('gulp-postcss');
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
const easings        = require('postcss-easings');
const rollup         = require('rollup');
const rollupBabel    = require('rollup-plugin-babel');
const rollupCommonjs = require('rollup-plugin-commonjs');
// const rollupUglify   = require('rollup-plugin-uglify-es');
const rollupResolveNodeModules = require('rollup-plugin-node-resolve');

/**
* Process JS.
*/
const processJs = done => {

    fs.readdirSync('./source/js').forEach(file => {

        if ( file.indexOf('_') === 0 ) {
            return;
        }

        let ext = path.extname(file)

        if ( ext === '.jsx' || ext === '.js' || ext === '.es' ) {

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
        }

        browsersync.stream()
        done()
    })
};

/**
* Process CSS.
*/
const processCss = done => {

    const config = {
        sourceFiles : ['./source/scss/*.scss'],
        destFolder: './public/css',
    };

    return src(config.sourceFiles)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sassglob())
        .pipe(sass({ outputStyle: 'expanded' }))
        .pipe(postcss([
            // tailwindcss('./tailwind.js'),
            tailwindcss(),
            autoprefixer(),
            // github.com/ai/webp-in-css/
            // easings(),
            // cssnano({ zindex : false }),
            // mqpacker(),
        ]))
        // .pipe(gulp.dest(config.destFolder))
        // .pipe(rename({ extname : '.min.css' }))
        .pipe(sourcemaps.write('./'))
        .pipe(dest(config.destFolder))
        .pipe(browsersync.stream());
};


/**
* Create translation (POT) file for WordPress.
*/
const processPot = done => {

    const config = {
        textdomain: 'primera',
    };

    return src('**/*.php')
        .pipe(wppot({ domain : config.textdomain }))
        .pipe(dest('./languages/' + config.textdomain + '.pot'));
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
            // "./app/**/*.php",
            // "./source/views/**/*.blade.php",
            "./public/css/**/*.css",
            "./public/js/**/*.js",
            "./public/img/**/*",
        ],
    };
    browsersync.init( config );
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

    watch('source/js/**/*.js', processJs);
    watch('source/scss/**/*.scss', processCss);
    // NOTE: PHP files need a solid reload, for CSS & JS to reflect the lastet changes.
    watch('**/**/*.php', reloadBrowser);
}

const develop = done => {
    return series(
        parallel(processCss, processJs),
        parallel(initBrowserSync, watchFiles)
    )
}

exports.default = series(
    parallel(processCss, processJs),
    parallel(initBrowserSync, watchFiles),
    reloadBrowser
)

exports.develop = exports.default

// exports.build = series(
//     // minify scripts
//     // make pot file
//     // shift off dev files
//     // zip build files?
// )

// exports.deploy = series(
//     // push to git branch that deploys to server
// )

exports.js = series(
    processJs,
    reloadBrowser
);

