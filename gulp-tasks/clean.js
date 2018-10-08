import chalk from 'chalk';
import del from 'del';
import gulp from 'gulp';

const log = console.log;

/**
 * Function to clean the CSS dist folder.
 *
 * @param {Object} atts an Object of file properties.
 * @param {Function} cb the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('clean', (cb) => {
  log(chalk.blue('--- Cleaning dist folders ---'));
  del(['./src/js/compiled/**/*', './dist/css/**/*', './dist/js/**/*', './dist/svg/**/*']);
  cb();
});


