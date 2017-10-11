
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var gulpLoadPlugins = require('gulp-load-plugins');
var $ = gulpLoadPlugins();
// var cleanCSS = require('gulp-clean-css');

var input = 'assets/css';

gulp.task('sass', function () {
    gulp.src(input)
        .pipe(sass().on('error', sass.logError))
        .pipe( autoprefixer(
            "Android 2.3",
            "Android >= 4",
            "Chrome >= 20",
            "Firefox >= 24",
            "Explorer >= 8",
            "iOS >= 6",
            "Opera >= 12",
            "Safari >= 6" ) )
        .pipe(gulp.dest('web/build'));
});

gulp.task("components:js", function() {
    return gulp.src([
        'node_modules/jquery/dist/jquery.slim.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
    ])
    .pipe($.concat('components.js'))
    .pipe(gulp.dest('web/build'));
});

gulp.task("components:css", function() {
    return gulp.src([
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/bootstrap/dist/css/bootstrap-theme.min.css',
        'node_modules/font-awesome/css/font-awesome.min.css',
    ])
    .pipe($.concat('components.css'))
    .pipe(gulp.dest('web/build'));
});

gulp.task("build", ['sass', 'components:js', 'components:css']);

gulp.task("default", ['sass'], function() {
    gulp.watch(input, ['sass']);
});
