const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass');
sass.compiler = require('node-sass');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
//const svgSprite = require('gulp-svg-sprite');
// const concat = require('gulp-concat');

//
// SVG Sprite Config
//
// const config = {
//     shape: {
//         dimension: {
//             maxWidth: 32,
//             maxHeight: 32,
//             precision: 2,
//             attributes: false,
//         },

//     },
//     mode: {
//         symbol: {
//             dest: './',
//             sprite: 'sprite.svg'
//         }
//     },
//     dest: './'
// };

//
// Tasks
//
//
function css() {
    return src('./application/views/scss/main-ltr.scss', './application/views/scss/main-rtl.scss')
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./application/views/css'));
}

// Watch files
function watchFiles() {
    watch(['./application/views/scss'], css);
}

exports.default = css;
exports.watch = watchFiles;