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
    .sourceMaps();
    

mix.browserSync({
    proxy: 'http://127.0.0.1:8000/',
    files: [
        'resources/views/**/*.php',
        'resources/js/**/*.js',
        'resources/sass/**/*.scss',
        'resources/**/*.vue', 
        'public/js/**/*.js',
        'public/css/**/*.css'
    ],
    notify: false    
});