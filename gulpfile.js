'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    cssmin = require('gulp-cssmin');

var sassvg = require('gulp-sassvg');

//gulp.task('sass:svg', function(){
//    return gulp.src('./frontend/web/img/svg/**/*.svg')
 //       .pipe(sassvg({
 //           outputFolder: './frontend/web/css/scss/', // IMPORTANT: this folder needs to exist
 //           optimizeSvg: true // true (default) means about 25% reduction of generated file size, but 3x time for generating the _icons.scss file
 //       }));
//});

var paths = {
    js: [
        './frontend/web/js/src/*.js',
        './frontend/widgets/bitcoinCalculator/assets/js/src/*.js'
    ],
    css: []
};

gulp.task('sass:css', function () {
    return gulp.src('./frontend/web/css/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(cssmin())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./frontend/web/css'));
});

gulp.task('sass:watch', function () {
    gulp.watch('./frontend/web/css/scss/**/*.scss', ['sass:css']);
});

// JS COMPRESSED
gulp.task('js', function () {
    paths.js.forEach(function (d) {
        var path = d.substring(0, d.lastIndexOf('/')) + '/..';
        gulp.src(d)
            .pipe(sourcemaps.init())
            .pipe(uglify())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(path))
    });
});

gulp.task('js:watch', function () {
    gulp.watch('./frontend/web/js/src/*.js', ['js']);
});

gulp.task('watch', ['sass:watch', 'js:watch']);