/**********************************************************************************
	- File Info -
		File name		: gulpfile.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 26 Jan 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
var gulp = require("gulp");
var sourcemaps = require("gulp-sourcemaps");
var uglify = require("gulp-uglify");
var plumber = require("gulp-plumber");
var rename = require("gulp-rename");
var babel = require("gulp-babel");
var del = require("del");
var react = require("react");
var react_dom = require("react-dom");

const NODE_PATH = './node_modules/';
const VENDOR_PATH = './';

// === Main start ===
gulp.task('default', ['update-vendor', 'watch']);
gulp.task('dev-default', ['update-vendor', 'dev-watch']);

gulp.task('watch', ['jsx'], function()
{
    gulp.watch('./pp/src/jsx/**/*.jsx', ['jsx']);
});

gulp.task('dev-watch', ['dev-jsx'], function()
{
    gulp.watch('./pp/src/jsx/**/*.jsx', ['dev-jsx']);
});
// === Main end ===

// === Vendor start ===
gulp.task('update-vendor', ['clean-vendor', 'copy-vendor']);

gulp.task('copy-vendor', function()
{
	// --- jQuery ---
	gulp.src(NODE_PATH + 'jquery/dist/jquery.min.js')
        .pipe(debug({title: 'jquery js'}))
        .pipe(gulp.dest(VENDOR_PATH + 'jquery'));
	console.log('~ copied jQuery files.');


	// --- Twitter Bootstrap ---
	gulp.src(NODE_PATH + 'bootstrap/dist/css/bootstrap.min.css')
        .pipe(debug({title: 'bootstrap css'}))
        .pipe(gulp.dest(VENDOR_PATH + 'bootstrap/css'));
	gulp.src(NODE_PATH + 'bootstrap/dist/js/bootstrap.min.js')
        .pipe(debug({title: 'bootstrap js'}))
        .pipe(gulp.dest(VENDOR_PATH + 'bootstrap/js'));
	gulp.src(NODE_PATH + 'bootstrap/dist/fonts')
        .pipe(debug({title: 'bootstrap fonts'}))
        .pipe(gulp.dest(VENDOR_PATH + 'bootstrap/fonts'));
	console.log('~ copied Bootstrap files.');


	// --- Font-Awesome ---
	gulp.src(NODE_PATH + 'font-awesome/css/font-awesome.min.css')
        .pipe(debug({title: 'font-awesome css'}))
        .pipe(gulp.dest(VENDOR_PATH + 'font-awesome/css'));
	gulp.src(NODE_PATH + 'font-awesome/fonts/**')
        .pipe(debug({title: 'font-awesome fonts'}))
        .pipe(gulp.dest(VENDOR_PATH + 'font-awesome/fonts'));
	console.log('~ copied Font Awesome files.');


	// --- SB Admin 2 ---
	gulp.src(NODE_PATH + 'sb-admin-2/dist/css/sb-admin-2.min.css')
        .pipe(debug({title: 'sd-admin-2 css'}))
        .pipe(gulp.dest(VENDOR_PATH + 'sb-admin-2/dist/css'));
	gulp.src(NODE_PATH + 'sb-admin-2/dist/js/sb-admin-2.min.js')
        .pipe(debug({title: 'ab-admin-2 js'}))
        .pipe(gulp.dest(VENDOR_PATH + 'sb-admin-2/dist/js'));
	gulp.src(NODE_PATH + 'sb-admin-2/vendor/datatables*/**')
        .pipe(debug({title: 'ab-admin-2 datatables'}))
        .pipe(gulp.dest(VENDOR_PATH + 'sb-admin-2/vendor'));
	gulp.src(NODE_PATH + 'sb-admin-2/vendor/metisMenu/**')
        .pipe(debug({title: 'ab-admin-2 metis-menu'}))
        .pipe(gulp.dest(VENDOR_PATH + 'sb-admin-2/vendor/metisMenu'));
	console.log('~ copied SB Admin 2 files.');


	// --- ParsleyJS ---
	gulp.src([
            NODE_PATH + 'parsleyjs/dist/parsley.min.js',
            NODE_PATH + 'parsleyjs/dist/parsley.min.js.map'
        ])
        .pipe(debug({title: 'parsley js'}))
        .pipe(gulp.dest(VENDOR_PATH + 'parsleyjs'));
	console.log('~ copied ParsleyJs files.');

    // --- React JS ---
    gulp.src([
        NODE_PATH + 'react/dist/**.js',
        NODE_PATH + 'react-dom/dist/**.js'
    ]).pipe(gulp.dest(VENDOR_PATH + 'react'));
    console.log('Copied React files');
});

gulp.task('clean-vendor', function()
{
	del.sync([
		VENDOR_PATH + 'bootstrap/**',
		VENDOR_PATH + 'font-awesome/**',
		VENDOR_PATH + 'jquery/**',
		VENDOR_PATH + 'parsleyjs/**',
		VENDOR_PATH + 'sb-admin-2/**',
        VENDOR_PATH + 'react/!**',
		'!' + VENDOR_PATH
	]);
});
// === Vendor end ===

// === React JS start ===
gulp.task('jsx', function()
{
    gulp.src('./pp/src/jsx/**.jsx')
        .pipe(plumber({errorHandler:function(err) {
            console.log(err);
        }}))
        .pipe(babel({
            'presets':['es2015', 'react'],
            'plugins':['syntax-object-rest-spread']
        }))
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min',
            extname: '.js'}))
        .pipe(gulp.dest('./pp/dist/js/'));
});

gulp.task('dev-jsx', function()
{
    gulp.src('./pp/src/jsx/**.jsx')
        .pipe(sourcemaps.init())
        .pipe(plumber({errorHandler:function(err) {
            console.log(err);
        }}))
        .pipe(babel({
            'presets':['es2015', 'react'],
            'plugins':['syntax-object-rest-spread']
        }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./pp/dist/js/'));
});

gulp.task('clean-js', function()
{
    console.log('--- task: delete STARTED ---');

    del.sync([
        './pp/dist/js/**',
        './pp/src/js/**',
        '!' + './pp/dist/js',
        '!' + './pp/src/js'
    ]);

    console.log('--- task: delete ENDED ---');
});
// === React JS end ===