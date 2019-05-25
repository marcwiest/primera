
const { src, dest, watch, series, parallel } = require('gulp');

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

let config = {};

/**
* Build.
*/
const build = done => {
    // minify scripts
    // make pot file
    // shift off dev files
    // zip build files
};
const deploy = done => {
    // push to git branch that deploys to server
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
                rollupResolveNodeModules(),
                rollupCommonjs(),
                rollupBabel(),
                // rollupUglify(),
            ]
        })
        .then(bundle => {
            return bundle.write({
                file: config.destFolder,
                // format: 'umd',
                // name: 'app',
                format: 'iife',
                sourcemap: true,
            });
        })
        .then(browsersync.stream());
};

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
            tailwindcss(),
            autoprefixer(),
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

    config = {
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
    config = {
        watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
        proxy: 'primera',
        tunnel: false, // can be a string
        notify: false,
        open: false,
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
const reloadBrowser = ( done ) => {
    browsersync.reload();
    done();
};

/**
* Watch task.
*
* The paths must be absolute (not realtive ./) for newly added files to be recognized during watch.
* https://github.com/sindresorhus/gulp-ruby-sass/issues/11#issuecomment-33660887
*/
const watchFiles = () => {

    watch('source/js/**/*.js', processJs);
    watch('source/scss/**/*.scss', processCss);
};

exports.default = series(
    parallel(processCss, processJs),
    parallel(initBrowserSync, watchFiles)
);

exports.js = series(
    processJs,
    reloadBrowser
);

