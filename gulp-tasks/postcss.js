import atImport from 'postcss-import';
import chalk from 'chalk';
import cssnano from 'gulp-cssnano';
import gulp from 'gulp';
import inlineSVG from 'postcss-inline-svg';
import livereload from 'gulp-livereload';
import mixins from 'postcss-mixins';
import postcss from 'gulp-postcss';
import presetEnv from 'postcss-preset-env';
import rename from 'gulp-rename';
import rgbaFallback from 'postcss-color-rgba-fallback';
import sourcemaps from 'gulp-sourcemaps';
import svg from 'postcss-svg';
import vars from 'postcss-simple-vars';

const log = console.log;

/**
 * Function to run PostCSS against files in a src directory.
 *
 * @param   {Object}   atts an Object of file properties.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('postcss', () => {
  const opts = {
    dest: './dist/css',
    src: [
      './src/css/admin-style.css',
      './src/css/style.css'
    ]
  };
  log(chalk.redBright('--- Running PostCSS Goodness ---'));

  return gulp.src(opts.src)
    .pipe(sourcemaps.init({loadMaps: true}))
	  .pipe(postcss([
      atImport(),
      mixins(),
      vars(),
      presetEnv({
        stage: 0
      }),
      inlineSVG({
        path: './dist/svg'
      }),
      rgbaFallback()
    ]))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(opts.dest))
    .pipe(livereload());
});

