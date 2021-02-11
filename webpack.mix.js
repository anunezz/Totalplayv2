const mix = require('laravel-mix');
let JavaScriptObfuscator = require('webpack-obfuscator');
//mix.browserSync({proxy: 'localhost:8000'});
mix.copy('resources/img', 'public/img');
mix.copy('resources/fonts', 'public/fonts');



let aux = [];
if (mix.inProduction()) {
    aux = [
        new JavaScriptObfuscator({
            compact: true,
            rotateUnicodeArray: true,
            identifierNamesGenerator: 'hexadecimal',
        })
    ]
}

mix.webpackConfig({
    plugins: aux,
});

mix.styles([
    'resources/css/plantilla.css',
], 'public/css/plantilla.css');

mix.js('resources/js/app.js', 'public/js')
    .sourceMaps()
    .version();


