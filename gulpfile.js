const { src, dest, watch, series, parallel, task } = require("gulp");
const sass = require('gulp-sass')(require('sass'));
sass.compiler = require("node-sass");
const sourcemaps = require("gulp-sourcemaps");
const autoprefixer = require("gulp-autoprefixer");
const minify = require("gulp-minify");
/* const svgSprite = require("gulp-svg-sprite");
var concat = require("gulp-concat"); */
const applicationPath = './application/views/';
const adminPath = './admin/views/';
const dashboardPath = './dashboard/views/';
const mapPath = '../../../';

// SVG Sprite Config
const config = {
    shape: {
        dimension: {
            maxWidth: 32,
            maxHeight: 32,
            precision: 2,
            attributes: false,
        },
    },
    mode: {
        symbol: {
            dest: "./",
            sprite: "sprite.yokart.svg",
        },
    },
    dest: "./",
};



function css() {
    return src(applicationPath + "scss/*.scss")
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass({ outputStyle: "compressed" }))
        .pipe(autoprefixer())
        // .pipe(sourcemaps.write(mapPath))
        .pipe(dest(applicationPath + "css"));
}

function manager() {
    return src(adminPath + "scss/*.scss")
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass({ outputStyle: "compressed" }))
        .pipe(autoprefixer())
        // .pipe(sourcemaps.write("."))
        .pipe(dest(adminPath + "css"));
}

function dashboard() {
    return src(dashboardPath + "scss/*.scss")
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass({ outputStyle: "compressed" }))
        .pipe(autoprefixer())
        // .pipe(sourcemaps.write("."))
        .pipe(dest(dashboardPath + "css"));
}

/* function svg() {
    return src("./manager/views/images/retina/sprites/*.svg")
        .pipe(svgSprite(config))
        .pipe(dest("./manager/views/images/retina"));
} */

// Watch minifyjs
function minifyjs() {
    return src(applicationPath + "common-js-src/*.js", { allowEmpty: true })
        .pipe(minify({ noSource: true }))
        // .pipe(concat("myapp.js"))
        .pipe(dest(applicationPath + "common-js"));
}

// Watch files
function watchFiles() {
    watch([applicationPath + "common-js-src/*.js"], minifyjs);
    watch([applicationPath + "scss"], css);
    watch([dashboardPath + "scss"], dashboard);
    watch([adminPath + "scss"], manager);
}

exports.default = series(minifyjs, css, dashboard, manager);
exports.watch = watchFiles;
