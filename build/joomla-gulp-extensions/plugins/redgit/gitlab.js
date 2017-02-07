var gulp = require('gulp');

// Load config
var config = require('../../../gulp-config.json');

// Dependencies
var browserSync = require('browser-sync');
var del         = require('del');

var group = 'redgit';
var name = 'gitlab';

var baseTask = 'plugins.' + group + '.' + name;
var extPath  = '../extensions/plugins/' + group + '/' + name;
var wwwPath  = config.wwwDir + '/plugins/' + group + '/' + name;

// Clean
gulp.task('clean:' + baseTask, function() {
	return del(wwwPath, {force : true});
});

// Copy
gulp.task('copy:' + baseTask, ['clean:' + baseTask], function() {
	return gulp.src( extPath + '/**')
		.pipe(gulp.dest(wwwPath));
});

// Watch
gulp.task('watch:' + baseTask,
	[
		'watch:' + baseTask + ':plugin'
	],
	function() {
});

// Watch: plugin
gulp.task('watch:' + baseTask + ':plugin', function() {
	gulp.watch(extPath + '/**/*', ['copy:' + baseTask, browserSync.reload]);
});
