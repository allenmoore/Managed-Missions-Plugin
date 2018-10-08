import chalk from 'chalk';
import gulp from 'gulp';
import livereload from 'gulp-livereload';

const log = console.log,
  nodeDir = './node_modules',
  cssOpts = {
    dest: './src/css/vendor',
    vendorFiles: ''
  },
  compiledDir = './src/js/compiled',
  jsOpts = {
    srcDest: './dist/js',
    srcFiles: [
      `${compiledDir}/**/*.js`,
      `${compiledDir}/**/*.map`
    ],
    vendorDest: './dist/js/vendor',
    vendorFiles: []
  };

/**
 * Function to concat all files in a src directory.
 *
 * @param   {Object}   atts an Object of file properties.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('copy', () => {
  log(chalk.green('--- Copying JS Src Files ---'));

  return gulp.src(jsOpts.srcFiles)
    .pipe(gulp.dest(jsOpts.srcDest))
    .pipe(livereload());
});
