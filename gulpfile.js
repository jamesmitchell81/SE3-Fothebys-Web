'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');

var sassPath = "./resources/css/";

gulp.task('default', function() {

});

gulp.task('sass', function () {
  // return gulp.src('./sass/**/*.scss')
  return gulp.src(sassPath + 'main.sass')
             .pipe(sass().on('error', sass.logError))
             .pipe(gulp.dest('./public/css'));
});

gulp.task('sass:watch', function () {
  gulp.watch(sassPath + '*.sass', ['sass']);
});