import gulp from 'gulp';
import requireDir from 'require-dir';

requireDir('./gulp-tasks');

/**
 * Gulp task to run all the Clean processes in a sequenctial order.
 *
 * @param   {String}   'clean-files' the task name.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('clean-files', gulp.series('clean', (done) => {
  done();
}))

/**
 * Gulp task to run all JavaScript processes in a sequenctial order.
 *
 * @param   {String}   'js' the task name.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('css', gulp.series('postcss', function(done) {
  done();
}));

/**
 * Gulp task to run all JavaScript processes in a sequenctial order.
 *
 * @param   {String}   'js' the task name.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('svg', gulp.series('svgmin', function(done) {
  done();
}));

/**
 * Gulp task to run all JavaScript processes in a sequenctial order.
 *
 * @param   {String}   'js' the task name.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('js', gulp.series('javascript', function(done) {
  done();
}));

/**
 * Gulp task to run all JavaScript processes in a sequenctial order.
 *
 * @param   {String}   'js' the task name.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('concat-js', gulp.series('concat', function(done) {
  done();
}));

/**
 * Gulp task to run all JavaScript processes in a sequenctial order.
 *
 * @param   {String}   'js' the task name.
 * @param   {Function} cb   the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('copy-js', gulp.series(['copy'], function(done) {
  done();
}));

/**
 * Gulp task to run all minification processes in a sequencial order.
 *
 * @param   {String}   'minify' the task name.
 * @param   {Function} cb       the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('minify', gulp.series(['uglify', 'cssnano'], function(done) {
  done();
}));

gulp.task('watch', () => {
  gulp.watch('./src/css/**/*.css', gulp.series(['clean-files', 'css', 'minify']));
  gulp.watch('./src/js/**/*.js', gulp.series(['clean-files', 'js', 'concat-js', 'copy-js', 'minify']));
  gulp.watch('./src/svg/**/*.svg', gulp.series(['clean-files', 'svg']));
})

/**
 * Gulp task to run the default build processes in a sequenctial order.
 *
 * @param   {String}   'default' the task name.
 * @param   {Function} cb        the pipe sequence that gulp should run.
 * @returns {void}
 */
gulp.task('default', gulp.series(['clean-files', 'svg', 'css', 'js', 'concat-js', 'copy-js', 'minify'], function(done) {
  done();
}));
