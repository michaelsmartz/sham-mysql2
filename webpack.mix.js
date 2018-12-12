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
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
        'picker': 'pickadate/lib/picker'
      }
    },
    devtool: "source-map",
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery', 
        'window.jQuery': 'jquery'/*,
        Popper: ['popper.js', 'default'],*/
      }),
      new CompressionPlugin({
        asset: '[path].gz[query]',
        algorithm: 'gzip',
        test: /\.html$|\.svg$/,
        threshold: 10240,
        minRatio: 0.8,
      }),
    ]
});

//mix.js('resources/assets/js/app.js', 'public/js');
//mix.js('resources/assets/js/alt-app.js', 'public/js');
mix.js('resources/assets/js/new-employee.js', 'public/js');
mix.js('resources/assets/js/employees.js', 'public/js/employees.js');
mix.js('resources/assets/js/uploader.js', 'public/js');
mix.js('resources/assets/js/parsley.js', 'public/js');
mix.js('resources/assets/js/recruitment.js', 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css', {
    outputStyle: 'nested'
});
mix.sass('resources/assets/sass/employees.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/dropzone.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/lifecycle.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/hopscotch.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/import_steps.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/nav-wizard.scss', 'public/css', {
  outputStyle: 'nested'
});

mix/*.webpackConfig({
    externals:{
        'Popper': 'popper.js'
    }
})*/.js('resources/assets/js/tables.js', 'public/js')


//mix.minify('public/js/app.js');
//mix.minify('public/js/alt-app.js');
mix.minify('public/js/tables.js');
mix.minify('public/js/parsley.js');
mix.minify('public/js/new-employee.js');
//if (!mix.inProduction()) {
  //mix.minify('public/js/employees.js');
//}
mix.minify('public/js/uploader.js');
mix.minify('public/js/recruitment.js');

mix.minify('public/css/app.css');
mix.minify('public/css/employees.css');
mix.minify('public/css/dropzone.css');
mix.minify('public/css/lifecycle.css');
mix.minify('public/css/hopscotch.css');
mix.minify('public/css/import_steps.css');
mix.minify('public/css/nav-wizard.css');

mix.then(() => {
    minifier.minify('public/css/app.css');
    minifier.minify('public/css/employees.css');
    minifier.minify('public/css/dropzone.css');
    minifier.minify('public/css/lifecycle.css');
    minifier.minify('public/css/hopscotch.css');
    minifier.minify('public/css/import_steps.css');
    minifier.minify('public/css/nav-wizard.css');

    //minifier.minify('public/js/app.js');
    //minifier.minify('public/js/alt-app.js');
    minifier.minify('public/js/tables.js');
    minifier.minify('public/js/uploader.js');
    minifier.minify('public/js/parsley.js');
    minifier.minify('public/js/recruitment.js');
    if (!mix.inProduction()) {
      //minifier.minify('public/js/employees.js');
    }
});
