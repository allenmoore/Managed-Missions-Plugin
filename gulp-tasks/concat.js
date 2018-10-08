import buffer from 'vinyl-buffer';
import chalk from 'chalk';
import concat from 'gulp-concat';
import gulp from 'gulp';
import livereload from 'gulp-livereload';
import sourcemaps from 'gulp-sourcemaps';

const log = console.log;

/**
 * Function to concat all files in a src directory.
 *
 * @author  Allen Moore
 * @param   {Object}   atts an Object of file properties.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('concat', () => {
  log(chalk.red('--- Concating JS Files ---'));

  return gulp.src(['./src/js/compiled/**/*.js', '!./src/js/compiled/build.js'])
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(buffer())
    .pipe(concat('build.js'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./src/js/compiled/'))
    .pipe(livereload());
});
