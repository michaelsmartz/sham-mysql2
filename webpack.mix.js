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
        'window.jQuery': 'jquery' /*,
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

if(!mix.inProduction){
  mix.js('resources/assets/js/new-employee.js', 'public/js');
}else{
  mix.js('resources/assets/js/new-employee.js', 'public/js').babel('public/js/new-employee.js','public/js/new-employee.min.js');
  mix.js('resources/assets/js/absence_type.js', 'public/js').babel('public/js/absence_type.js','public/js/absence_type.min.js');
  mix.js('resources/assets/js/calendar.js', 'public/js').babel('public/js/calendar.js','public/js/calendar.min.js');
}

mix.js('resources/assets/js/employees.js', 'public/js/employees.js');
mix.js('resources/assets/js/uploader.js', 'public/js');
mix.js('resources/assets/js/parsley.js', 'public/js');
mix.js('resources/assets/js/recruitment.js', 'public/js');
mix.js('resources/assets/js/recruitment-request.js', 'public/js');
mix.js('resources/assets/js/my-vacancies.js', 'public/js');
mix.js('resources/assets/js/candidates.js', 'public/js');
mix.js('resources/assets/js/leaves.js', 'public/js');
mix.js('resources/assets/js/myteam.js', 'public/js');
//mix.js('resources/assets/js/vue-component-test.js', 'public/js');
mix.js('resources/assets/js/tinymce.js', 'public/js');
mix.js('resources/assets/js/app2.js', 'public/js');

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
mix.sass('resources/assets/sass/candidates.scss', 'public/css', {
    outputStyle: 'nested'
});
mix.sass('resources/assets/sass/tinymce-custom.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/flatpickr.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/leaves.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/myteam.scss', 'public/css', {
    outputStyle: 'nested'
});
mix.sass('resources/assets/sass/calendar.scss', 'public/css', {
    outputStyle: 'nested'
});
mix.sass('resources/assets/sass/portal-calendar.scss', 'public/css', {
  outputStyle: 'nested'
});
mix.sass('resources/assets/sass/public-vacancies.scss', 'public/css', {
  outputStyle: 'nested'
});

mix/*.webpackConfig({
    externals:{
        'Popper': 'popper.js'
    }
})*/.js('resources/assets/js/tables.js', 'public/js')


mix.minify('public/js/app2.js');
mix.minify('public/js/tables.js');
mix.minify('public/js/parsley.js');
if(!mix.inProduction){
  mix.minify('public/js/new-employee.js');
  mix.minify('public/js/absence_type.js');
  mix.minify('public/js/calendar.js');
}
mix.minify('public/js/uploader.js');
mix.minify('public/js/recruitment.js');
mix.minify('public/js/recruitment-request.js');
mix.minify('public/js/my-vacancies.js');
mix.minify('public/js/candidates.js');

mix.minify('public/js/leaves.js');
mix.minify('public/js/myteam.js');
mix.minify('public/js/tinymce.js');

mix.minify('public/css/app.css');
mix.minify('public/css/employees.css');
mix.minify('public/css/dropzone.css');
mix.minify('public/css/lifecycle.css');
mix.minify('public/css/hopscotch.css');
mix.minify('public/css/import_steps.css');
mix.minify('public/css/nav-wizard.css');
mix.minify('public/css/candidates.css');
mix.minify('public/css/flatpickr.css');
mix.minify('public/css/leaves.css');
mix.minify('public/css/myteam.css');
mix.minify('public/css/calendar.css');
mix.minify('public/css/portal-calendar.css');
mix.minify('public/csspublic-vacancies.css');

mix.then(() => {
    minifier.minify('public/css/app.css');
    minifier.minify('public/css/employees.css');
    minifier.minify('public/css/dropzone.css');
    minifier.minify('public/css/lifecycle.css');
    minifier.minify('public/css/hopscotch.css');
    minifier.minify('public/css/import_steps.css');
    minifier.minify('public/css/nav-wizard.css');
    minifier.minify('public/css/candidates.css');
    minifier.minify('public/css/tinymce-custom.css');
    minifier.minify('public/css/flatpickr.css');
    minifier.minify('public/css/leaves.css');
    minifier.minify('public/css/myteam.css');

    minifier.minify('public/js/tables.js');
    minifier.minify('public/js/uploader.js');
    minifier.minify('public/js/parsley.js');
    minifier.minify('public/js/recruitment.js');
    minifier.minify('public/js/recruitment-request.js');
    minifier.minify('public/js/my-vacancies.js');
    minifier.minify('public/js/candidates.js');
    minifier.minify('public/js/leaves.js');
    minifier.minify('public/js/myteam.js');
    minifier.minify('public/js/app2.js');
    
});
