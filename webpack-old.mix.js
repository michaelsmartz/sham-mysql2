let mix = require('laravel-mix');
let minifier = require('minifier');

// BABEL config
mix.webpackConfig({
    module: {
      rules: [
        {
          test: /\.jsx?$/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['es2015'] // default == env
            }
          }
        }
      ]
    }
})

mix.webpackConfig({
    resolve: {
        alias: {
			'jquery-ui': 'jquery-ui/ui/widgets',
			'jquery-ui-css': 'jquery-ui/../../themes/base',
            'pace': 'pace-progress'
        }
    }
});

mix.autoload({
    jquery: ['$', 'jQuery', 'jquery', 'window.jQuery'],
    Pace: 'pace',
    asyncjs: 'asyncJS'
});

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

mix
   .js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/tables.js', 'public/js');
mix
   .sass('resources/assets/sass/app.scss', 'public/css', {
    outputStyle: 'nested'
});

// you usually only want to minify this in production

//if(mix.inProduction()) {
    mix.minify('public/js/app.js');
    mix.minify('public/js/tables.js');
    mix.minify('public/css/app.css');
 //}

mix.then(() => {
    minifier.minify('public/css/app.css');
    minifier.minify('public/js/app.js');
    minifier.minify('public/js/tables.js');
});
