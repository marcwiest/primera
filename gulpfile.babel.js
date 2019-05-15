
const { src, dest, watch, series, parallel } = require('gulp');

const autoprefixer = require('autoprefixer');
const browsersync  = require('browser-sync').create();
const mqpacker     = require('css-mqpacker');
const babel        = require("gulp-babel");
const cssnano      = require('gulp-cssnano');
const connectphp   = require('gulp-connect-php');
const gulpif       = require('gulp-if');
const imagemin     = require('gulp-imagemin');
const plumber      = require('gulp-plumber');
const postcss      = require('gulp-postcss');
const rename       = require('gulp-rename');
const replace      = require('gulp-replace');
const sass         = require('gulp-sass');
const sassglob     = require('gulp-sass-glob');
const sourcemaps   = require('gulp-sourcemaps');
const uglify       = require('gulp-uglify');
const wppot        = require('gulp-wp-pot');
const mozjpeg      = require('imagemin-mozjpeg');
const pngquant     = require('imagemin-pngquant');
const easings      = require('postcss-easings');
const rollup       = require('rollup');
const rollupBabel  = require('rollup-plugin-babel');




let config = {};

/**
* Process CSS.
*/
const processCss = done => {

    config = {
        sourceFiles : ['./source/scss/**/*.scss'],
        destFolder: './public/css',
    };

    return src(config.sourceFiles)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sassglob())
        .pipe(sass({ outputStyle: 'expanded' }))
        .pipe(postcss([
            // tailwindcss('./tailwind.js'),
            autoprefixer(),
            easings(),
            // mqpacker(),
        ]))
        // .pipe(gulp.dest(config.destFolder))
        .pipe(cssnano({ zindex : false }))
        // .pipe(rename({ extname : '.min.css' }))
        .pipe(sourcemaps.write('./'))
        .pipe(dest(config.destFolder))
        .pipe(browsersync.stream());
};

/**
* Process JS.
*/
const processJs = done => {

    config = {
        sourceFiles: ['./source/js/app.js'],
        destFolder: './public/js/app.js',
    };

    return rollup.rollup({
        input: config.sourceFiles,
        plugins: [
            rollupBabel()
        ]
    }).then(bundle => {
        return bundle.write({
            file: config.destFolder,
            // format: 'umd',
            // name: 'app',
            format: 'iife',
            sourcemap: true
        });
    }).then(browsersync.stream());
};


/**
* Create translation (POT) file for WordPress.
*/
const processPot = done => {

    config = {
        textdomain : 'primera',
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
    config = {
        watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
        proxy: 'primera',
        notify: false,
        tunnel: false,
        files: [
            "./source/views/**/*.blade.php",
            "./public/css/**/*.css",
            "./public/js/**/*.js",
            "./public/img/**/*",
        ],
    };

    browsersync.init( config );
    done();
};

/**
* Causes BrowserSync to do full window refresh.
*/
const reloadBrowserSync = ( done ) => {
    browsersync.reload();
    done();
};

/**
* Watch task.
*
* The paths must be absolute (not realtive ./) for newly added files to be recognized during watch.
* https://github.com/sindresorhus/gulp-ruby-sass/issues/11#issuecomment-33660887
*/
const doWatch = () => {

    watch('source/js/**/*.js', processJs);
    watch('source/scss/**/*.scss', processCss);
};

exports.default = series(
    parallel(processCss, processJs),
    parallel(initBrowserSync, doWatch)
);

exports.js = series(
    processJs,
    reloadBrowserSync
);

