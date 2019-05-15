
const { src, dest, watch, series, parallel } = require('gulp');

// var pkg = require('./package.json');
// var config = require('./config/theme.js');

const autoprefixer = require('autoprefixer');
const browsersync  = require('browser-sync').create();
const mqpacker     = require('css-mqpacker');
const cssnano      = require('gulp-cssnano');
const gulpif       = require('gulp-if');
const imagemin     = require('gulp-imagemin');
const plumber      = require('gulp-plumber');
const postcss      = require('gulp-postcss');
// const rename       = require('gulp-rename');
// const replace      = require('gulp-replace');
const sass         = require('gulp-sass');
const sassglob     = require('gulp-sass-glob');
const sourcemaps   = require('gulp-sourcemaps');
const uglify       = require('gulp-uglify');
const wppot        = require('gulp-wp-pot');
const mozjpeg      = require('imagemin-mozjpeg');
const pngquant     = require('imagemin-pngquant');
const easings      = require('postcss-easings');


/**
* Process CSS.
*/
const doCss = done => {

    let config = {
        sourceFiles : ['./source/sass/*'],
        destFolder: './public/css',
    };

    let stream = gulp.src(config.sourceFiles)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sassglob())
        .pipe(sass({ outputStyle: 'expanded' }))
        .pipe(postcss([
            // tailwindcss('./tailwind.js'),
            autoprefixer(),
            easings(),
            mqpacker()
        ]))
        // .pipe(gulp.dest(config.destFolder))
        .pipe(cssnano({ zindex : false }))
        // .pipe(rename({ extname : '.min.css' }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.destFolder))
        .pipe(browsersync.stream());

    return stream;
};

/**
* Process JS.
*/
const doJs = done => {

    let config = {
        concatName: 'app.js',
        sourceFiles : ['./source/js/app.js'],
        destFolder : './public/js',
    };

    var stream = gulp.src(config.sourceFiles)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(concat(config.concatName))
        .pipe(babel())
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.destFolder))
        .pipe(browsersync.stream());

    return stream;
};

/**
* Create translation (POT) file for WordPress.
*/
const doPot = done => {

    let config = {
        textdomain : 'primera',
    };

    var stream = gulp.src('**/*.php')
        .pipe(wppot({ domain : config.textdomain }))
        .pipe(gulp.dest('./languages/' + config.textdomain + '.pot'));

    return stream;
};

/**
* Initialize BrowserSync and it's PHP server.
*/
const initBrowserSync = done => {

    // browsersync.io/docs/options
    let config = {
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

    browserSync.init( config );

    done();
};

/**
* Watch task.
*
* The paths must be absolute (not realtive ./) for newly added files to be recognized.
* https://github.com/sindresorhus/gulp-ruby-sass/issues/11#issuecomment-33660887
*/
const doWatch = done => {

    // gulp.watch('resources/sass/**/*.css', ['css']);
    // gulp.watch('resources/javascript/**/*.js', ['js']);
};

exports.default = doWatch;
exports.browserSync = initBrowserSync;

