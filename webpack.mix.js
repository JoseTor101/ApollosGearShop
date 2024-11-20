const mix = require('laravel-mix');

mix.js('resources/js/api.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
   ]);
