var gulp      = require('gulp');
var config    = require('../../../gulp-config.json');

var watchInterval = 500;
if (typeof config.watchInterval !== 'undefined') {
	watchInterval = config.watchInterval;
}

// Dependencies
var browserSync = require('browser-sync');
var del         = require('del');
var fs          = require('fs');
var path        = require('path');

var modName   = "database";
var modFolder = "mod_redgit_" + modName;
var modBase   = "admin";

var baseTask  = 'modules.backend.' + modName;
var extPath   = '../extensions/modules/' + modBase + '/' + modFolder;
var mediaPath = extPath + '/media/' + modFolder;

var wwwPath      = config.wwwDir + '/administrator/modules/' + modFolder;
var wwwMediaPath = config.wwwDir + '/media/' + modFolder;

// Clean
gulp.task('clean:' + baseTask,
	[
		'clean:' + baseTask + ':module',
		'clean:' + baseTask + ':media'
	],
	function() {
});

// Clean: Module
gulp.task('clean:' + baseTask + ':module', function() {
	return del(wwwPath, {force: true});
});

// Clean: Media
gulp.task('clean:' + baseTask + ':media', function() {
	return del(wwwMediaPath, {force: true});
});

// Copy: Module
gulp.task('copy:' + baseTask,
	[
		'clean:' + baseTask,
		'copy:' + baseTask + ':module',
		'copy:' + baseTask + ':media'
	],
	function() {
});

// Copy: Module
gulp.task('copy:' + baseTask + ':module', ['clean:' + baseTask + ':module'], function() {
	return gulp.src([
			extPath + '/**',
			'!' + extPath + '/media',
			'!' + extPath + '/media/**'
		])
		.pipe(gulp.dest(wwwPath));
});

// Copy: Media
gulp.task('copy:' + baseTask + ':media', ['clean:' + baseTask + ':media'], function() {
	return gulp.src([
			mediaPath + '/**'
		])
		.pipe(gulp.dest(wwwMediaPath));
});

// Watch
gulp.task('watch:' + baseTask,
	[
		'watch:' + baseTask + ':module',
		'watch:' + baseTask + ':media'
	],
	function() {
});

// Watch: Module
gulp.task('watch:' + baseTask + ':module', function() {
	gulp.watch([
		extPath + '/**/*',
		'!' + extPath + '/media',
		'!' + extPath + '/media/**/*'
	],
	['copy:' + baseTask + ':module', browserSync.reload]);
});

// Watch: Media
gulp.task('watch:' + baseTask + ':media', function() {
	gulp.watch([
		mediaPath + '/**'
	],
	{ interval: watchInterval },
	['copy:' + baseTask + ':media', browserSync.reload]);
});
