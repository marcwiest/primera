'use strict';

// var pkg = require('./package.json');
var config = require('./config/theme.js');

var autoprefixer   = require('autoprefixer');
var gulp           = require('gulp');
var babel          = require('gulp-babel');
var mqpacker       = require('css-mqpacker');
var concat         = require('gulp-concat');
var cssnano        = require('gulp-cssnano');
var flatten        = require('gulp-flatten');
var postcss        = require('gulp-postcss');
var rename         = require('gulp-rename');
var replace        = require('gulp-replace');
var sass           = require('gulp-sass');
var sassGlob       = require('gulp-sass-glob');
var sourcemaps     = require('gulp-sourcemaps');
var uglify         = require('gulp-uglify');
var plumber        = require('gulp-plumber');
var wpPot          = require('gulp-wp-pot');
var easings        = require('postcss-easings');
var browserSync    = require('browser-sync').create();


/**
* Process CSS.
*/
gulp.task( 'css', function() {

    var stream = gulp.src( config.dev.css.files )
        .pipe( plumber() )
        .pipe( sourcemaps.init() )
        .pipe( sassGlob() )
        .pipe( sass({ outputStyle : 'expanded' }) )
        .pipe( postcss([
            // tailwindcss('./tailwind.js'),
            autoprefixer(),
            easings(),
            mqpacker()
        ]) )
        // .pipe( gulp.dest('./public/css') )
        .pipe( cssnano({ zindex : false }) )
        // .pipe( rename({ extname : '.min.css' }) )
        .pipe( sourcemaps.write('./') )
        .pipe( flatten() )
        .pipe( gulp.dest('./public/css') )
        .pipe( browserSync.stream() );

    return stream;

});


/**
* Process JS.
*/
gulp.task( 'js', function() {

    var stream = gulp.src( config.dev.js.files )
        .pipe( plumber() )
        .pipe( sourcemaps.init() )
        .pipe( concat( 'app.js' ) )
        // .pipe( babel() )
        .pipe( uglify() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./public/js') )
        .pipe( browserSync.stream() );

    return stream;

});


/**
* Create translation (POT) file.
*/
gulp.task( 'potfile', function() {

    var stream = gulp.src( '**/*.php' )
        .pipe( wpPot({ domain : config.textdomain }) )
        .pipe( gulp.dest('./languages/' + config.textdomain + '.pot') );

    return stream;

});


/**
* Initialize BrowserSync and it's PHP server.
*/
gulp.task( 'initBrowserSync', ['css','js'], function() {

    // browsersync.io/docs/options
    browserSync.init({
        watchEvents : [ 'change', 'add', 'unlink', 'addDir', 'unlinkDir' ],
        proxy       : config.dev.browserSync.proxy,
        notify      : config.dev.browserSync.notify,
        tunnel      : config.dev.browserSync.tunnel,
        files       : config.dev.browserSync.files
    });

});


/**
* Watch task.
*
* The paths must be absolute (not realtive ./) for newly added files to be recognized.
* https://github.com/sindresorhus/gulp-ruby-sass/issues/11#issuecomment-33660887
*/
gulp.task( 'watch', ['initBrowserSync'], function() {

    gulp.watch( 'resources/sass/**/*.scss', ['css'] );
    gulp.watch( 'resources/javascript/**/*.js', ['js'] );

});


/**
* Gulp default task.
*/
gulp.task( 'default', ['watch'] );


/**
* Gulp build task.
*/
gulp.task( 'build', ['css','js','potfile'] );
