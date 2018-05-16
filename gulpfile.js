'use strict';

// var pkg = require('./package.json');

const LOCALHOST_ADDRESS = 'localhost/primera';
const LOCALHOST_PORT    = 8888;

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
        .pipe( sass({ outputStyle : 'expanded' }) )
        .pipe( postcss([
            cssnext(),
            propertyLookup(),
            easings(),
            mqpacker()
        ]) )
        .pipe( cssnano({ zindex : false }) )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') )
        .pipe( browserSync.stream() );

    return stream;

});


/**
* Process JS.
*/
gulp.task( 'js', function() {

    var files = [
        './js/util.js',
        './js/script.js'
    ];

    var stream = gulp.src( files )
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
        port        : LOCALHOST_PORT,
        proxy       : LOCALHOST_ADDRESS,
        notify      : false,
        tunnel      : true,
        watchEvents : [ 'change', 'add', 'unlink', 'addDir', 'unlinkDir' ],
        files       : [
            './images/**/*',
            './script.js',
            './style.css',
            './**/*.php',
            './**/*.{woff,ttf,svg,eot}'
        ]
    });

});


/**
* Watch task.
*/
gulp.task( 'watch', ['initBrowserSync'], function() {

    gulp.watch( './scss/**/*.scss', ['css'] );
    gulp.watch( './js/**/*.js', ['js'] );
    
});


/**
* Gulp default task.
*/
gulp.task( 'default', ['watch'] );


/**
* Gulp build task.
*/
gulp.task( 'build', ['css','js','imgmin','potfile'] );
