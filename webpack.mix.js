const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
  .js( 'resources/js/message_box.js', 'public/js' )
  .js( 'resources/js/crop_profile.js', 'public/js' )
  .js( 'resources/js/admin/navbar.js', 'public/js/admin' )
  .js( 'resources/js/admin/config.js', 'public/js/admin' )
  .js( 'resources/js/orders/show.js', 'public/js/orders' )
  .js( 'resources/js/orders/confirmation.js', 'public/js/orders' )
  .autoload({"jquery": [ '$', 'window.jQuery' ],})
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/top.scss', 'public/css')
  .sass('resources/sass/main.scss', 'public/css')
  .sass('resources/sass/form.scss', 'public/css')
  .sass('resources/sass/message_box.scss', 'public/css')
  .sass('resources/sass/orders/table.scss', 'public/css/orders')
  .sass('resources/sass/orders/index.scss', 'public/css/orders')
  .sass('resources/sass/orders/show.scss', 'public/css/orders')
  .sass('resources/sass/orders/create.scss', 'public/css/orders')
  .sass('resources/sass/orders/confirmation.scss', 'public/css/orders')
  .sass('resources/sass/errors/500.scss', 'public/css/errors')
  .sass('resources/sass/admin/show.scss', 'public/css/admin')
  .sass('resources/sass/admin/config.scss', 'public/css/admin')
  .sass('resources/sass/admin/forgot-password.scss', 'public/css/admin')
  .sass('resources/sass/admin/login.scss', 'public/css/admin')
  .sass('resources/sass/admin/navbar.scss', 'public/css/admin')
  .sourceMaps();