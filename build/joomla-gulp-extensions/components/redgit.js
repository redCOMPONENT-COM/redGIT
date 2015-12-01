var gulp = require('gulp');

var config = require('../../gulp-config.json');

// Dependencies
var browserSync = require('browser-sync');
var del         = require('del');

var componentName   = 'redgit';
var baseTask        = 'components.' + componentName;
var extPath         = '../extensions/components/' + componentName;
var wwwFrontendPath = config.wwwDir + '/components/com_' + componentName;
var wwwBackendPath  = config.wwwDir + '/administrator/components/com_' + componentName;

// Clean
gulp.task('clean:' + baseTask,
	[
		'clean:' + baseTask + ':frontend',
		'clean:' + baseTask + ':backend'
	],
	function() {
		return true;
});

// Clean: frontend
gulp.task('clean:' + baseTask + ':frontend', function() {
	return del(wwwFrontendPath, {force : true});
});

// Clean: backend
gulp.task('clean:' + baseTask + ':backend', function() {
	return del(wwwBackendPath, {force : true});
});

// Copy
gulp.task('copy:' + baseTask,
	[
		'copy:' + baseTask + ':frontend',
		'copy:' + baseTask + ':backend'
	],
	function() {
		return true;
});

// Copy: frontend
gulp.task('copy:' + baseTask + ':frontend', ['clean:' + baseTask + ':frontend'], function() {
	return gulp.src(extPath + '/site/**')
		.pipe(gulp.dest(wwwFrontendPath));
});

// Copy: backend
gulp.task('copy:' + baseTask + ':backend', ['clean:' + baseTask + ':backend'], function(cb) {
	return (
		gulp.src([
			extPath + '/admin/**'
		])
		.pipe(gulp.dest(wwwBackendPath)) &&
		gulp.src(extPath + '/' + componentName +'.xml')
		.pipe(gulp.dest(wwwBackendPath)) &&
		gulp.src(extPath + '/install.php')
		.pipe(gulp.dest(wwwBackendPath))
	);
});

// Watch
gulp.task('watch:' + baseTask,
	[
		'watch:' + baseTask + ':frontend',
		'watch:' + baseTask + ':backend'
	],
	function() {
});

// Watch: frontend
gulp.task('watch:' + baseTask + ':frontend', function() {
	gulp.watch(extPath + '/site/**/*',
	['copy:' + baseTask + ':frontend', browserSync.reload]);
});

// Watch: backend
gulp.task('watch:' + baseTask + ':backend', function() {
	gulp.watch([
		extPath + '/admin/**/*',
		extPath + '/' + componentName + '.xml',
		extPath + '/install.php'
	],
	['copy:' + baseTask + ':backend', browserSync.reload]);
});
