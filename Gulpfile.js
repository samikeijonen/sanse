/*

REQUIRED STUFF
==============
*/

var changed     = require('gulp-changed');
var gulp        = require('gulp');
var sass        = require('gulp-sass');
var sourcemaps  = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();
var notify      = require('gulp-notify');
var prefix      = require('gulp-autoprefixer');
var minifycss   = require('gulp-clean-css');
var cssnano     = require('gulp-cssnano');
var del         = require('del');
var rename      = require('gulp-rename');
var uglify      = require('gulp-uglify');
var cache       = require('gulp-cache');
var concat      = require('gulp-concat');
var util        = require('gulp-util');
var header      = require('gulp-header');
var pixrem      = require('gulp-pixrem');
var exec        = require('child_process').exec;
var wpPot       = require('gulp-wp-pot');
var sort        = require('gulp-sort');
var zip         = require('gulp-zip');

/*

FILE PATHS
==========
*/

var sassSrc      = 'assets/sass/**/*.{sass,scss}';
var sassFile     = 'assets/sass/style.scss';
var styleFile    = 'style.css';
var cssDest      = './'; // Create style.css file.
var customjs     = 'assets/js/scripts.js';
var jsSrc        = ['assets/js/*.js', '!assets/js/*.min.js', '!assets/js/customizer.js'];
var jsDest       = 'assets/js';
var phpFiles     = ['./*.php', './**/*.php'];
var project      = 'sanse'; // Project name.
var build        = './build/sanse/';
var buildInclude = [
    '**',
    '!node_modules/**/',
    '!assets/sass/**/*',
    '!build/**/',
    '!.git/**',
    '!Gulpfile.js',
    '!package.json',
    '!.gitignore',
    '!.gitmodules',
    '!.tx/**',
    '!**/*~',
];
/*

ERROR HANDLING
==============
*/

var handleError = function(task) {
  return function(err) {

      notify.onError({
        message: task + ' failed, check the logs..'
      })(err);

    util.log(util.colors.bgRed(task + ' error:'), util.colors.red(err));
  };
};

/*

BROWSERSYNC
===========

Notes:
   - Add only file types you are working on - if watching the whole themeDir,
     task trigger will be out of sync because of the sourcemap-files etc.
   - Adding only part of the files will also make the task faster

*/

gulp.task('browsersync', function() {

  var files = [
    '**/*.php',
    '**/*.css',
    jsSrc
  ];

  browserSync.init(files, {
    proxy: "localhost/sanse",
    browser: "Google Chrome",
    notify: true
  });

});

/*

STYLES
======
*/

gulp.task('sass-styles', function() {

  gulp.src(sassFile)

    .pipe(sass({
      compass: false,
      bundleExec: true,
      sourcemap: false,
      outputStyle: 'expanded',
      debugInfo: true,
      lineNumbers: true,
      errLogToConsole: true
    }))

    .on('error', handleError('styles'))
    .pipe(prefix('last 3 version', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4')) // Adds browser prefixes (eg. -webkit, -moz, etc.)
    .pipe(pixrem())
    /*.pipe(minifycss({
      advanced: true,
      keepBreaks: false,
      keepSpecialComments: 0,
      mediaMerging: true,
      sourceMap: true
    }))*/
    .pipe(gulp.dest(cssDest))
    .pipe(browserSync.stream());

});

/**
 * Prefix style.css rules.
 */
gulp.task('prefix:styles', function() {
	
	gulp.src(styleFile)
	.pipe(prefix('last 3 version')) // Adds browser prefixes (eg. -webkit, -moz, etc.)
	.pipe(gulp.dest(cssDest))
	.pipe(browserSync.stream());
	
});

/**
 * Delete style.min.css before we minify and optimize
 */
gulp.task('clean:styles', function() {
	return del(['style.min.css'])
});

/**
 * Minify and optimize style.css.
 *
 * https://www.npmjs.com/package/gulp-cssnano
 */
gulp.task('cssnano', ['clean:styles'], function() {
	return gulp.src('style.css')
	.pipe(cssnano({
		safe: true // Use safe optimizations
	}))
	.pipe(rename('style.min.css'))
	.pipe(gulp.dest('./'))
	.pipe(browserSync.stream());
});

/*

SCRIPTS
=======
*/

var currentDate   = util.date(new Date(), 'dd-mm-yyyy HH:ss');
var pkg       = require('./package.json');
var banner      = '/*! <%= pkg.name %> <%= currentDate %> - <%= pkg.author %> */\n';

gulp.task('uglify', function() {

	return gulp.src(jsSrc)
	.pipe(rename({suffix: '.min'}))
	.pipe(uglify({
		mangle: false
	}))
	.pipe(gulp.dest(jsDest));
});

/**
 * Scan the theme and create a POT file.
 *
 * https://www.npmjs.com/package/gulp-wp-pot
 */
gulp.task('wp-pot', function() {
	return gulp.src(phpFiles)
	//.pipe(plumber({ errorHandler: handleErrors }))
	.pipe(sort())
	.pipe(wpPot({
		domain: 'sanse',
		destFile:'sanse.pot',
		package: 'sanse',
		bugReport: 'https://foxland.fi/contact/',
		lastTranslator: 'Sami Keijonen <sami.keijonen@foxnet.fi>',
		team: 'Sami Keijonen <sami.keijonen@foxnet.fi>'
	}))
	.pipe(gulp.dest('languages/'));
});

/**
 * Delete build folder before we proceed.
 */
gulp.task('clean:build', function() {
	return del(['build/sanse/**/*'])
});

/**
 * Build task that moves essential theme files for production-ready sites
 *
 * buildFiles copies all the files in buildInclude to build folder - check variable values at the top
 */

 gulp.task('build-folder', ['clean:build'], function() {
   return gulp.src(buildInclude)
   .pipe(gulp.dest(build))
   .pipe(notify({ message: 'Copy from buildFiles complete', onLast: true }));
 });
 
 /**
 * Delete unneccessary folders from build.
 */
gulp.task('clean:unneccessary', function() {
	return del(['./build/sanse/node_modules/**/*', './build/sanse/build/**/*'])
});

/*

WATCH
=====

*/

// Run the JS task followed by a reload
gulp.task('js-watch', ['js'], browserSync.reload);
gulp.task('watch', ['browsersync'], function() {

  gulp.watch(sassSrc, ['styles']);
  gulp.watch(jsSrc, ['js-watch']);

});

/**
 * Create indivdual tasks.
 */
gulp.task('i18n', ['wp-pot']);
gulp.task('scripts', ['uglify']);
gulp.task('styles', ['prefix:styles', 'cssnano']);
gulp.task('build', ['build-folder', 'clean:unneccessary']);
gulp.task('default', ['i18n', 'styles', 'scripts', 'build']);