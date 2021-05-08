"use strict";

const { src, dest } = require("gulp");
const gulp = require("gulp");
const autoprefixer = require("gulp-autoprefixer");
const cssbeautify = require("gulp-cssbeautify");
const removeComments = require("gulp-strip-css-comments");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const cssnano = require("gulp-cssnano");
const uglify = require("gulp-uglify");
const plumber = require("gulp-plumber");
const imagemin = require("gulp-imagemin");
const del = require("del");
const notify = require("gulp-notify");
const webpack = require("webpack");
const webpackStream = require("webpack-stream");
const browserSync = require("browser-sync").create();

/* Paths */
const srcPath = "resources/";
const distPath = "public/";

const path = {
    build: {
        js: distPath + "/js/",
        css: distPath + "/css/"
    },
    src: {
        js: srcPath + "assets/js/*.js",
        css: srcPath + "assets/scss/**/*.scss",
    },
    watch: {
        js: srcPath + "assets/js/**/*.js",
        css: srcPath + "assets/scss/**/*.scss",
    },
};

/* Tasks */

function serve() {
    browserSync.init({
        proxy: "http://127.0.0.1:8000/"
    });
}

function css(cb) {
    return src(path.src.css, { base: srcPath + "assets/scss/" })
        .pipe(
            plumber({
                errorHandler: function (err) {
                    notify.onError({
                        title: "SCSS Error",
                        message: "Error: <%= error.message %>",
                    })(err);
                    this.emit("end");
                },
            })
        )
        .pipe(
            sass({
                includePaths: "./node_modules/",
            })
        )
        .pipe(
            autoprefixer({
                cascade: true,
            })
        )
        .pipe(cssbeautify())
        .pipe(dest(path.build.css))
        .pipe(
            cssnano({
                zindex: false,
                discardComments: {
                    removeAll: true,
                },
            })
        )
        .pipe(removeComments())
        .pipe(
            rename({
                suffix: ".min",
                extname: ".css",
            })
        )
        .pipe(dest(path.build.css))
        .pipe(browserSync.reload({ stream: true }));

    cb();
}

function cssWatch(cb) {
    return src(path.src.css, { base: srcPath + "assets/scss/" })
        .pipe(
            plumber({
                errorHandler: function (err) {
                    notify.onError({
                        title: "SCSS Error",
                        message: "Error: <%= error.message %>",
                    })(err);
                    this.emit("end");
                },
            })
        )
        .pipe(
            sass({
                includePaths: "./node_modules/",
            })
        )
        .pipe(
            rename({
                suffix: ".min",
                extname: ".css",
            })
        )
        .pipe(dest(path.build.css))
        .pipe(browserSync.reload({ stream: true }));

    cb();
}

function js(cb) {
    return src(path.src.js, { base: srcPath + "assets/js/" })
        .pipe(
            plumber({
                errorHandler: function (err) {
                    notify.onError({
                        title: "JS Error",
                        message: "Error: <%= error.message %>",
                    })(err);
                    this.emit("end");
                },
            })
        )
        .pipe(dest(path.build.js))
        .pipe(browserSync.reload({ stream: true }));

    cb();
}

function jsWatch(cb) {
    return src(path.src.js, { base: srcPath + "assets/js/" })
        .pipe(
            plumber({
                errorHandler: function (err) {
                    notify.onError({
                        title: "JS Error",
                        message: "Error: <%= error.message %>",
                    })(err);
                    this.emit("end");
                },
            })
        )
        .pipe(
            webpackStream({
                mode: "development",
                output: {
                    filename: "app.js",
                },
            })
        )
        .pipe(dest(path.build.js))
        .pipe(browserSync.reload({ stream: true }));

    cb();
}




function watchFiles() {
    gulp.watch([path.watch.css], cssWatch);
    gulp.watch([path.watch.js], jsWatch);
}

const build = gulp.series( gulp.parallel(css, js));
const watch = gulp.parallel(build, watchFiles, serve);

/* Exports Tasks */

exports.css = css;
exports.js = js;


exports.build = build;
exports.watch = watch;
exports.default = watch;
