import gulp from 'gulp';
import stylelint from 'gulp-stylelint';

/**
 * Function to concat all files in a src directory.
 *
 * @param   {Object}   atts an Object of file properties.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('lint-css', () => {
  const opts = {
    dest: './reports/lint/css',
    src: ['./src/css/**/*.css']
  };

  return gulp.src(opts.src)
    .pipe(stylelint({
      failAfterError: true,
      reportOutputDir: opts.dest,
      reporters: [
        {
          formatter: 'verbose',
          console: true
        },
        {
          formatter: 'json',
          save: 'report.json'
        },
      ],
      debug: true
    }));
});
