'use strict';

const THEME_TEXT_DOMAIN = 'primera';

var pjson      = require('./package.json');
var gulp       = require('gulp');
var babel      = require('gulp-babel');
var concat     = require('gulp-concat');
var cssnano    = require('gulp-cssnano');
var imagemin   = require('gulp-imagemin');
var livereload = require('gulp-livereload');
var postcss    = require('gulp-postcss');
var replace    = require('gulp-replace');
var sourcemaps = require('gulp-sourcemaps');
var uglify     = require('gulp-uglify');
var wpPot      = require('gulp-wp-pot');
var pngquant   = require('imagemin-pngquant');
var lostGrid   = require('lost');
var cssnext    = require('postcss-cssnext');
var atExtend   = require('postcss-extend');
var atImport   = require('postcss-import');


/**
* Minify CSS
*/
gulp.task( 'cssmin', function() {

    var stream = gulp.src( './css/style.css' )
        .pipe( sourcemaps.init() )
        // Replace primera version before concatenation.
        .pipe( replace( '{{version}}', pjson.version ) )
        // Concatenate files via atImport.
        .pipe( postcss([ atImport(), atExtend(), cssnext(), lostGrid() ]) )
        // Replace shoelace version after concatenation.
        .pipe( replace( '{{version}}', pjson.shoelaceVersion ) )
        .pipe( cssnano() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') );

    return stream;

});


/**
* Minify JS
*/
gulp.task( 'jsmin', function() {

    var jsFiles = [
        './js/shoelace/dropdowns.js',
        './js/shoelace/tabs.js',
        './js/tools.js',
        './js/theme.js',
        './js/init.js'
    ];

    var stream = gulp.src( jsFiles )
        .pipe( sourcemaps.init() )
        .pipe( concat('script.js') )
        .pipe( babel() )
        .pipe( uglify() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') );

    return stream;

});


/**
* Minify Images
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
* Gulp Watch
*/
gulp.task( 'watch', function() {

    // Minify CSS
    gulp.watch( './css/**/*.css', ['cssmin'] );

    // Minify JS
    gulp.watch( './js/**/*.js', ['jsmin'] );

    // Live Reload (Remember, you must activate the browser extension!)
    livereload.listen();
    gulp.watch([
            './**/*.php',
            './app.js',
            './style.css'
        ],
        function( path ) {
            livereload.changed( path );
        }
    );

});


/**
* Gulp Default
*/
gulp.task( 'default', ['cssmin','jsmin','imgmin','potfile'] );
