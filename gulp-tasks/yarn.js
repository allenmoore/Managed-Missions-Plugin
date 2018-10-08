import chalk from 'chalk';
import gulp from 'gulp';
import yarn from 'gulp-yarn';

const log = console.log;

/**
 * Function to run Yarn.
 *
 * @param {Object} atts an Object of file properties.
 * @param {Function} cb the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('yarn', () => {
  log(chalk.blue('--- Running Yarn ---'));

  return gulp.src(['./package.json', 'yarn.lock'])
     .pipe(yarn());
});


