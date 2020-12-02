const mix = require('laravel-mix');
//mix.browserSync({proxy: 'localhost:8000'});
mix.copy('resources/img', 'public/img');
mix.copy('resources/fonts', 'public/fonts');

mix.styles([
    'resources/css/plantilla.css',
], 'public/css/plantilla.css');

mix.js('resources/js/app.js', 'public/js')
    .sourceMaps()
    .version();


