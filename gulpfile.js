const { src, dest, watch, series, parallel } = require("gulp");
const sass = require("gulp-sass");
sass.compiler = require("node-sass");
const sourcemaps = require("gulp-sourcemaps");
const autoprefixer = require("gulp-autoprefixer");
const minify = require("gulp-minify");

function css() {
  return src("./application/views/scss/*.scss")
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sass({ outputStyle: "compressed" }))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write("."))
    .pipe(dest("./application/views/css"));
}

function manager() {
  return src("./manager/views/scss/*.scss")
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sass({ outputStyle: "compressed" }))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write("."))
    .pipe(dest("./manager/views/css"));
}

function dashboard() {
  return src("./dashboard/views/scss/*.scss")
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sass({ outputStyle: "compressed" }))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write("."))
    .pipe(dest("./dashboard/views/css"));
}

// Watch files
function watchFiles() {
  watch(["./application/views/scss"], css);
  watch(["./dashboard/views/scss"], dashboard);
  watch(["./manager/views/scss"], manager);
}

exports.default = series(css, dashboard, manager);
exports.watch = watchFiles;
