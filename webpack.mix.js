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
  .sass('resources/sass/app.scss', 'public/css')
  .copy('node_modules/font-awesome/css/font-awesome.css', 'public/css/font-awesome.css')
  .copy('node_modules/font-awesome/fonts', 'public/fonts');

mix.copy('node_modules/swagger-ui-dist/swagger-ui.css',
  'public/css/swagger-ui/swagger-ui.css')
.copy('node_modules/swagger-ui-dist/swagger-ui-bundle.js',
  'public/js/swagger-ui/swagger-ui-bundle.js')
.copy('node_modules/swagger-ui-dist/swagger-ui-bundle.js.map',
  'public/js/swagger-ui/swagger-ui-bundle.js.map')
.copy('node_modules/swagger-ui-dist/swagger-ui-standalone-preset.js',
  'public/js/swagger-ui/swagger-ui-standalone-preset.js');

