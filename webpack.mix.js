let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/vuejs/src/main.js', 'public/js')
  .sass('resources/vuejs/scss/style.scss', 'public/css')
  .less('resources/vuejs/fonts/fontawesome.less', 'public/css');

