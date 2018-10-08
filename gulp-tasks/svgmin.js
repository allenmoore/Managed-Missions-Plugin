import chalk from 'chalk';
import gulp from 'gulp';
import svgmin from 'gulp-svgmin';

const log = console.log;

/**
 * Function to concat all files in a src directory.
 *
= * @param   {Object}   atts an Object of file properties.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('svgmin', () => {
  const opts = {
    dest: './dist/svg',
    src: './src/svg/**/*.svg'
  };

  log(chalk.cyanBright('--- Cleaning up all of those wonderful SVG files ---'));

  return gulp.src(opts.src)
	  .pipe(svgmin({
      plugins: [
        {mergePaths: false},
        {removeViewBox: false},
        {removeRasterImages: false},
        {removeTitle: false},
        {sortAttrs: false}
      ]
    }))
	  .pipe(gulp.dest(opts.dest));
});
