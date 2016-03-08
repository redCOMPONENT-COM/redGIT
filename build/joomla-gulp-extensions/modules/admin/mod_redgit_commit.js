var gulp      = require('gulp');
var config    = require('../../../gulp-config.json');

var watchInterval = 500;
if (typeof config.watchInterval !== 'undefined') {
	watchInterval = config.watchInterval;
}

// Dependencies
var browserSync = require('browser-sync');
var concat      = require('gulp-concat');
var del         = require('del');
var fs          = require('fs');
var gutil       = require('gulp-util');
var rename      = require('gulp-rename');
var uglify      = require('gulp-uglify');

var modName   = "commit";
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

// Scripts
gulp.task('scripts:' + baseTask,
	[
		'scripts:' + baseTask + ':module'
	],
	function() {
});

function compileScripts(src, ouputFileName, destinationFolder) {
	return gulp.src(src)
		.pipe(concat(ouputFileName))
		.pipe(gulp.dest(mediaPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwMediaPath + '/' + destinationFolder))
		.pipe(uglify().on('error', gutil.log))
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(mediaPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwMediaPath + '/' + destinationFolder));
}

// Scripts: module
gulp.task('scripts:' + baseTask + ':module', function () {
	return compileScripts(
		[
			'./media/modules/' + modBase + '/' + modFolder + '/js/module.js'
		],
		'module.js',
		'js'
	);
});

// Watch
gulp.task('watch:' + baseTask,
	[
		'watch:' + baseTask + ':module',
		'watch:' + baseTask + ':media',
		'watch:' + baseTask + ':scripts'
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
		mediaPath + '/**',
		'!' + mediaPath + '/js/**'
	],
	{ interval: watchInterval },
	['copy:' + baseTask + ':media', browserSync.reload]);
});

// Watch: scripts
gulp.task('watch:' + baseTask + ':scripts', function() {
    gulp.watch([
    	'./media/modules/' + modBase + '/' + modFolder + '/js/**/*.js'
    ], ['scripts:' + baseTask, browserSync.reload]);
});
