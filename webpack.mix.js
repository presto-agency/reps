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
    .js('resources/assets/js/register_tournament.js', 'public/js/assets')
    .js('resources/assets/js/load_galleries.js', 'public/js/assets')
    .js('resources/assets/js/load_forum_sections.js', 'public/js/assets')
    .js('resources/assets/js/load_forum_sections_show.js', 'public/js/assets')
    .js('resources/assets/js/load_tournament.js', 'public/js/assets')
    .js('resources/assets/js/replay_iframe.js', 'public/js/assets')
    .js('resources/assets/js/stream_select.js', 'public/js/assets')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .version();
