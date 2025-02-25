const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Add this line to compile Vue.js files
//    .sass('resources/sass/app.scss', 'public/css');
