const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass');
sass.compiler = require('node-sass');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');

function css() {
    return src('scss/*.scss')
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(sourcemaps.write('.')) 
        .pipe(dest('css')); 
}

// Watch files
function watchFiles() {
    watch(['scss'], css);
}

exports.default = css;
exports.watch = watchFiles;