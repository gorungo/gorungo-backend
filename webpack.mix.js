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

const WebpackShellPlugin = require('webpack-shell-plugin');

// Add shell command plugin configured to create JavaScript language file
mix.webpackConfig({
    plugins:
        [
            new WebpackShellPlugin({onBuildStart:['php artisan lang:js --quiet'], onBuildEnd:[]})
        ]
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/category.js', 'public/js/category.js')
    .js('resources/js/userui.js', 'public/js/userui.js')
    .sass('resources/sass/app.scss', 'public/css');


if (mix.inProduction()) {
    mix.version();
}
