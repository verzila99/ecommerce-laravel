const mix = require('laravel-mix');
require('laravel-mix-purgecss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .sass('resources/assets/scss/style.scss', 'css',{}, [
      require('autoprefixer'),require('cssnano')
    ]).purgeCss()
.browserSync('http://127.0.0.1:8000').webpackConfig({stats:{children: true}});
