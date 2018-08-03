let mix = require('laravel-mix');
let webpack = require('webpack');
let minifier = require('minifier');
const CompressionPlugin = require('compression-webpack-plugin');

// BABEL config
/*
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
*/

mix.autoload({
    tether: ['Tether', 'window.Tether']
});

mix
   .webpackConfig({
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery', 'window.jQuery': 'jquery',
        Popper: ['popper.js', 'default'],
      }),
      new CompressionPlugin({
        asset: '[path].gz[query]',
        algorithm: 'gzip',
        test: /\.js$|\.css$|\.html$|\.svg$/,
        threshold: 10240,
        minRatio: 0.8,
      }),
    ]
});

mix.js('resources/assets/js/app.js', 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css', {
    outputStyle: 'nested'
});

mix.webpackConfig({
    externals:{
        'Popper': 'popper.js'
    }
}).js('resources/assets/js/tables.js', 'public/js');

mix.minify('public/js/app.js');
mix.minify('public/js/tables.js');
mix.minify('public/css/app.css');

mix.then(() => {
    minifier.minify('public/css/app.css');
    minifier.minify('public/js/app.js');
    minifier.minify('public/js/tables.js');
});