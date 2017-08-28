
var gulp       = require('gulp');
var babel      = require('gulp-babel');
var concat     = require('gulp-concat');
var cssnano    = require('gulp-cssnano');
var imagemin   = require('gulp-imagemin');
var livereload = require('gulp-livereload');
var postcss    = require('gulp-postcss');
var sourcemaps = require('gulp-sourcemaps');
var uglify     = require('gulp-uglify');
var pngquant   = require('imagemin-pngquant');
var lostGrid   = require('lost');
var cssnext    = require('postcss-cssnext');
var atImport   = require('postcss-import');


/**
* Minify CSS
*/
gulp.task( 'cssmin', function() {

    var stream = gulp.src( './css/style.css' )
        .pipe( sourcemaps.init() )
        .pipe( postcss([ atImport(), lostGrid(), cssnext() ]) )
        .pipe( cssnano() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') );

    return stream;

});


/**
* Minify JS
*/
gulp.task( 'jsmin', function() {

    var stream = gulp.src( './js/**/*.js' )
        .pipe( sourcemaps.init() )
        .pipe( concat('app.js') )
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
* Gulp Watch
*/
gulp.task( 'watch', function() {

    // Minify CSS
    gulp.watch( './css/**/*.css', ['cssmin'] );

    // Minify JS
    gulp.watch( './js/**/*.js', ['jsmin'] );

    // Live Reload
    livereload.listen();
    gulp.watch([
            './*.php',
            './php/*.php',
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
gulp.task( 'default', ['cssmin','jsmin','imgmin'] );
