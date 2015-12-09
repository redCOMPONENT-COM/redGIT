var gulp = require('gulp');

var config = require('../../gulp-config.json');

// Dependencies
var browserSync = require('browser-sync');
var del         = require('del');

var baseTask     = 'libraries.redgit';
var extPath      = '../extensions/libraries/redgit';
var manifestFile = 'redgit.xml';
var wwwPath      = config.wwwDir + '/libraries/redgit';

// Clean
gulp.task('clean:' + baseTask,
	[
		'clean:' + baseTask + ':library',
		'clean:' + baseTask + ':manifest'
	],
	function() {
});

// Clean: library
gulp.task('clean:' + baseTask + ':library', function(cb) {
	return del(wwwPath, {force : true});
});

// Clean: manifest
gulp.task('clean:' + baseTask + ':manifest', function(cb) {
	return del(config.wwwDir + '/administrator/manifests/libraries/' + manifestFile, {force : true}, cb);
});

// Copy
gulp.task('copy:' + baseTask,
	[
		'copy:' + baseTask + ':library',
		'copy:' + baseTask + ':manifest'
	],
	function() {
});

// Copy: library
gulp.task('copy:' + baseTask + ':library',
	['clean:' + baseTask + ':library'], function() {
	return gulp.src([
		extPath + '/*(LICENSE|library.php)',
		extPath + '/language/**',
		extPath + '/layout/**',
		extPath + '/layouts/**',
		extPath + '/src/**',
		extPath + '/vendor/**',
		'!' + extPath + '/vendor/**/doc',
		'!' + extPath + '/vendor/**/doc/**',
		'!' + extPath + '/vendor/**/docs',
		'!' + extPath + '/vendor/**/docs/**',
		'!' + extPath + '/vendor/**/test',
		'!' + extPath + '/vendor/**/test/**',
		'!' + extPath + '/vendor/**/tests',
		'!' + extPath + '/vendor/**/tests/**',
		'!' + extPath + '/vendor/**/Test',
		'!' + extPath + '/vendor/**/Test/**',
		'!' + extPath + '/vendor/**/Tests',
		'!' + extPath + '/vendor/**/Tests/**',
		'!' + extPath + '/vendor/**/composer.json'
	],{ base: extPath })
	.pipe(gulp.dest(wwwPath));
});

// Copy: manifest
gulp.task('copy:' + baseTask + ':manifest', ['clean:' + baseTask + ':manifest'], function() {
	return gulp.src(extPath + '/' + manifestFile)
		.pipe(gulp.dest(config.wwwDir + '/administrator/manifests/libraries'));
});

// Watch
gulp.task('watch:' + baseTask,
	[
		'watch:' + baseTask + ':library',
		'watch:' + baseTask + ':manifest'
	],
	function() {
});

// Watch: library
gulp.task('watch:' +  baseTask + ':library', function() {
	gulp.watch([
			extPath + '/**/*',
			'!' + extPath + '/' + manifestFile,
		], ['copy:' + baseTask + ':library', browserSync.reload]);
});

// Watch: manifest
gulp.task('watch:' +  baseTask + ':manifest', function() {
	gulp.watch(extPath + '/' + manifestFile, ['copy:' + baseTask + ':manifest', browserSync.reload]);
});
