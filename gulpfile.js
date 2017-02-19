const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/* Не удалять, позже будем использовать для оптимизации. Работает под Linux
require('laravel-elixir-image-optimize');*/

elixir(function(mix) {
    //app.scss includes app css, Boostrap and Ionicons
    mix.sass('app.scss')
        .less('./node_modules/admin-lte/build/less/AdminLTE.less', './public/css/adminlte-less.css')
        .less('adminlte-app.less')
        .less('form.less')
        .less('./node_modules/toastr/toastr.less')
        .styles([
            './public/css/app.css',
            './node_modules/admin-lte/dist/css/skins/_all-skins.css',
            './public/css/adminlte-less.css',
            './public/css/form.css',
            './public/css/adminlte-app.css',
            './node_modules/icheck/skins/square/blue.css',
            './public/css/toastr.css'
        ])
        .copy('node_modules/font-awesome/fonts/*.*','public/fonts/')
        .copy('node_modules/ionicons/dist/fonts/*.*','public/fonts/')
        .copy('node_modules/admin-lte/bootstrap/fonts/*.*','public/fonts/bootstrap')
        .copy('node_modules/admin-lte/dist/css/skins/*.*','public/css/skins')
        .copy('node_modules/admin-lte/dist/img','public/img')
        .copy('node_modules/admin-lte/plugins','public/plugins')
        .copy('node_modules/icheck/skins/square/blue.png','public/css')
        .copy('node_modules/icheck/skins/square/blue@2x.png','public/css')
        .webpack('app.js')
        .webpack('usercabinet.js')
        .webpack('landing.js')
        .webpack('bootstrap.min.js');

    mix.sass('general.scss');
    mix.sass('landing.scss');
    mix.copy('resources/assets/img', 'public/img');

    /* Не удалять, позже будем использовать для оптимизации. Работает под Linux
     mix.imageOptimize("./resources/assets/img", "public/img/");*/
});
