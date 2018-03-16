'use strict';

const THEME_TEXT_DOMAIN = 'primera';
const LOCALHOST_ADDRESS = 'localhost/primera';


var packagejson    = require('./package.json');
var gulp           = require('gulp');
var babel          = require('gulp-babel');
var mqpacker       = require('css-mqpacker');
var concat         = require('gulp-concat');
var cssnano        = require('gulp-cssnano');
var imagemin       = require('gulp-imagemin');
var livereload     = require('gulp-livereload');
var postcss        = require('gulp-postcss');
var rename         = require('gulp-rename');
var replace        = require('gulp-replace');
var sass           = require('gulp-sass');
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
        .pipe( replace( '{{version}}', packagejson.version ) )
        .pipe( sass({ outputStyle : 'expanded' }) )
        .pipe( postcss([
            cssnext(),
            propertyLookup(),
            easings(),
            mqpacker()
        ]) )
        .pipe( cssnano({ zindex : false }) )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') );

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
        .pipe( gulp.dest('./') );

    return stream;

});


/**
* Minify images.
*/
gulp.task( 'imgmin', function () {

    var stream = gulp.src('./img/*')
        .pipe( imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }) )
        .pipe( gulp.dest('./img') );

    return stream;

});


/**
* Create translation (POT) file.
*/
gulp.task( 'potfile', function () {

    var stream = gulp.src('**/*.php')
        .pipe( wpPot({
            domain: THEME_TEXT_DOMAIN
        }) )
        .pipe( gulp.dest('./languages/'+ THEME_TEXT_DOMAIN +'.pot') );

    return stream;

});


/**
* Gulp browserSync task.
*/
gulp.task( 'watch', function() {

    browserSync.init({
        port   : 8888,
        proxy  : LOCALHOST_ADDRESS,
        notify : false,
        tunnel : true
    });

    // Watch PHP
    gulp.watch( './**/*.php' ).on( 'change', browserSync.reload );

    // Watch CSS
    gulp.watch( './scss/**/*.scss', ['css'] ).on( 'change', browserSync.reload );

    // Watch JS
    gulp.watch( './js/**/*.js', ['js'] ).on( 'change', browserSync.reload );

});


/**
* Gulp default task.
*/
gulp.task( 'default', ['sync'] );


/**
* Gulp build task.
*/
gulp.task( 'build', ['css','js','imgmin','potfile'] );
