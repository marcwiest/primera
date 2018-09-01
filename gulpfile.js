'use strict';

// var pkg = require('./package.json');
var config = require('./theme-config.json');

var gulp           = require('gulp');
var babel          = require('gulp-babel');
var mqpacker       = require('css-mqpacker');
var concat         = require('gulp-concat');
var cssnano        = require('gulp-cssnano');
var imagemin       = require('gulp-imagemin');
var postcss        = require('gulp-postcss');
var rename         = require('gulp-rename');
var replace        = require('gulp-replace');
var sass           = require('gulp-sass');
var sassGlob       = require('gulp-sass-glob');
var sourcemaps     = require('gulp-sourcemaps');
var uglify         = require('gulp-uglify');
var plumber        = require('gulp-plumber');
var wpPot          = require('gulp-wp-pot');
var pngquant       = require('imagemin-pngquant');
var cssnext        = require('postcss-cssnext');
var easings        = require('postcss-easings');
var propertyLookup = require('postcss-property-lookup');
var browserSync    = require('browser-sync').create();


/**
* Process CSS.
*/
gulp.task( 'css', function() {

    var stream = gulp.src( './scss/style.scss' )
        .pipe( plumber() )
        .pipe( sourcemaps.init() )
        .pipe( sassGlob() )
        .pipe( sass({ outputStyle : 'compressed' }) )
        .pipe( postcss([
            cssnext(),
            propertyLookup(),
            easings(),
            mqpacker()
        ]) )
        // .pipe( gulp.dest('./') )
        .pipe( cssnano({ zindex : false }) )
        // .pipe( rename({ extname : '.min.css' }) )
        .pipe( gulp.dest('./') )
        .pipe( sourcemaps.write('./') )
        .pipe( browserSync.stream() );

    return stream;

});


/**
* Process JS.
*/
gulp.task( 'js', function() {

    // var files = [
    //     './js/util.js',
    //     './js/script.js'
    // ];

    var stream = gulp.src( config.dev.js.files )
        .pipe( plumber() )
        .pipe( sourcemaps.init() )
        .pipe( concat( 'script.js' ) )
        .pipe( babel() )
        .pipe( uglify() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') )
        .pipe( browserSync.stream() );

    return stream;

});


/**
* Minify images.
*/
gulp.task( 'imgmin', function () {

    var stream = gulp.src('./images/*')
        .pipe( imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }) )
        .pipe( gulp.dest('./images/optimized/') );

    return stream;

});


/**
* Create translation (POT) file.
*/
gulp.task( 'potfile', function () {

    var stream = gulp.src('**/*.php')
        .pipe( wpPot({
            domain: 'primeraTextDomain'
        }) )
        .pipe( gulp.dest('./languages/primeraTextDomain.pot') );

    return stream;

});


/**
* Initialize BrowserSync and it's PHP server.
*/
gulp.task( 'initBrowserSync', ['css','js'], function() {

    // browsersync.io/docs/options
    browserSync.init({
        watchEvents : [ 'change', 'add', 'unlink', 'addDir', 'unlinkDir' ],
        port        : config.dev.browserSync.port,
        proxy       : config.dev.browserSync.proxy,
        notify      : config.dev.browserSync.notify,
        tunnel      : config.dev.browserSync.tunnel,
        files       : config.dev.browserSync.files
        // files       : [
        //     './images/**/*',
        //     './script.js',
        //     './style.css',
        //     './**/*.php',
        //     './**/*.{woff,ttf,svg,eot}'
        // ]
    });

});


/**
* Watch task.
*
* The paths must be absolute (not realtive ./) for newly added files to be recognized.
* https://github.com/sindresorhus/gulp-ruby-sass/issues/11#issuecomment-33660887
*/
gulp.task( 'watch', ['initBrowserSync'], function() {

    gulp.watch( 'scss/**/*.scss', ['css'] );
    gulp.watch( 'js/**/*.js', ['js'] );

});


/**
* Gulp default task.
*/
gulp.task( 'default', ['watch'] );


/**
* Gulp build task.
*/
gulp.task( 'build', ['css','js','imgmin','potfile'] );
