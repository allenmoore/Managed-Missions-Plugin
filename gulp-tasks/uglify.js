import buffer from 'vinyl-buffer';
import chalk from 'chalk';
import copy from 'gulp-copy';
import gulp from 'gulp';
import livereload from 'gulp-livereload';
import rename from 'gulp-rename';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';

const log = console.log;

/**
 * Function to concat all files in a src directory.
 *
 * @param   {Object}   atts an Object of file properties.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('uglify', () => {
  log(chalk.yellowBright('--- Uglifying the JS ---'));

  return gulp.src(['./src/js/compiled/build.js'])
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(rename({suffix: '.min'}))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./dist/js'))
    .pipe(livereload());
});
