var elixir = require('laravel-elixir');
var paths = {
    'production': {
        'css': 'public/assets/css/',
        'js': 'public/assets/js/',
        'fonts': 'public/assets/fonts/'
    }
};

elixir(function (mix) {
    mix.copy('resources/assets/fonts', 'public/assets/css/fonts');
    mix.copy('resources/assets/css', 'public/assets/css');
    mix.copy('resources/assets/img', 'public/assets/img');
    mix.copy('resources/assets/global', 'public/assets/global');
    mix.copy('resources/assets/images', 'public/assets/images');
    mix.copy('resources/assets/images', 'public/images');
    mix.copy('resources/assets/js/respond.min.js', 'public/assets/js/respond.min.js');
    mix.copy('resources/assets/js/morris.min.js', 'public/assets/js/morris.min.js');
    mix.copy('resources/assets/js/excanvas.min.js', 'public/assets/js/excanvas.min.js');
    mix.copy('resources/assets/fonts', 'public/assets/fonts');
    mix.copy('resources/assets/css/ltr/modal-large.css', 'public/assets/css/modal-large.css');
    mix.copy('resources/assets/css/rtl/modal-large-rtl.css', 'public/assets/css/modal-large-rtl.css');
    mix.copy('resources/assets/css/rtl/morris.css', 'public/assets/css/morris.css');

    mix.less([
        'resources/assets/less/app/main.less',
        'resources/assets/less/app/print.less'
    ], paths.production.css + 'ajeer.css');

    mix.less([
        'resources/assets/less/vendor/vendor.less'
    ], paths.production.css + 'vendor.css');

    mix.styles([
        'font-awesome.min.css',
        'simple-line-icons.min.css',
        'bootstrap.min.css',
        'uniform.default.min.css',
        'bootstrap-switch.min.css',
        'components-md.min.css',
        'plugins-md.min.css',
        'select2.min.css',
        'select2-bootstrap.min.css',
        'layout.min.css',
        'toastr.min.css',
        'pace-theme-flash.css',
        'bootstrap-fileinput.css',
        'bootstrap-select.min.css',
        'jquery.dataTables.min.css',
        'jquery.calendars.picker.css',
        'morris.css',
        'admin-light.css',
        'custom.min.css'
    ], paths.production.css + 'app.css', 'resources/assets/css/ltr');

    mix.styles([
        'font-awesome.min.css',
        'simple-line-icons.min.css',
        //'bootstrap.min.css',
        'uniform.default.min.css',
        'bootstrap-switch.min.css',
        'components-md.min.css',
        'plugins-md.min.css',
        'datatables.min.css',
        'layout3.min.css',
        'default3.min.css',
        'toastr.min.css',
        'bootstrap-fileinput.css',
        'bootstrap-select.min.css',
        'normalize.css',
        'jquery.calendars.picker.css',
        'about.min.css',
        'custom-front.min.css'
    ], paths.production.css + 'front.css', 'resources/assets/css/ltr');

    mix.styles([
        'font-awesome.min.css',
        'simple-line-icons.min.css',
        'bootstrap.min.css',
        'uniform.default.min.css',
        'bootstrap-switch.min.css',
        'components-md.min.css',
        'plugins-md.min.css',
        'login.min.css'
    ], paths.production.css + 'login.css', 'resources/assets/css/ltr');

    mix.styles([
        'font-awesome.min.css',
        'simple-line-icons.min.css',
        'bootstrap-rtl.min.css',
        'uniform.default.min.css',
        'bootstrap-switch-rtl.min.css',
        'components-md-rtl.min.css',
        'plugins-md-rtl.min.css',
        'select2.min.css',
        'select2-bootstrap.min.css',
        'layout-rtl.min.css',
        'toastr-rtl.min.css',
        'pace-theme-flash-rtl.css',
        'bootstrap-fileinput.css',
        'bootstrap-select-rtl.min.css',
        'jquery.dataTables.min.css',
        'jquery.calendars.picker.css',
        'morris.css',
        'admin-light-rtl.css',
        'custom-rtl.min.css'
    ], paths.production.css + 'app-rtl.css', 'resources/assets/css/rtl');

    mix.styles([
        'font-awesome.min.css',
        'simple-line-icons.min.css',
        // 'bootstrap-rtl.min.css',
        'uniform.default.min.css',
        'bootstrap-switch-rtl.min.css',
        'components-md-rtl.min.css',
        'plugins-md-rtl.min.css',
        'datatables.min.css',
        'layout-rtl3.min.css',
        'default-rtl3.min.css',
        'toastr-rtl.min.css',
        'bootstrap-fileinput.css',
        'bootstrap-select-rtl.min.css',
        'normalize.css',
        'jquery.calendars.picker.css',
        'about.min.css',
        'custom-front-rtl.min.css'
    ], paths.production.css + 'front-rtl.css', 'resources/assets/css/rtl');

    mix.styles([
        'font-awesome.min.css',
        'simple-line-icons.min.css',
        'bootstrap-rtl.min.css',
        'uniform.default.min.css',
        'bootstrap-switch-rtl.min.css',
        'components-md-rtl.min.css',
        'plugins-md-rtl.min.css',
        'login-rtl.min.css',
        'custom-rtl.min.css'
    ], paths.production.css + 'login-rtl.css', 'resources/assets/css/rtl');

    mix.scripts([
        'pace.min.js',
        'jquery.min.js',
        'jquery-ui.min.js',
        'bootstrap.min.js',
        'js.cookie.min.js',
        'bootstrap-hover-dropdown.min.js',
        'jquery.slimscroll.min.js',
        'jquery.blockui.min.js',
        'jquery.uniform.min.js',
        'bootstrap-switch.min.js',
        'bootstrap-confirmation.min.js',
        'jquery.validate.min.js',
        'additional-methods.min.js',
        'toastr.min.js',
        'bootstrap-fileinput.js',
        'bootstrap-select.min.js',
        'app.min.js',
        'layout.min.js',
        'jquery.dataTables.min.js',
        'jquery.calendars.js',
        'jquery.calendars.islamic.js',
        'jquery.calendars.plus.js',
        'jquery.plugin.min.js',
        'jquery.calendars.picker.js',
        'custom.js'
    ], paths.production.js + 'app.js', 'resources/assets/js');

    mix.scripts([
        'jquery.min.js',
        'jquery-ui.min.js',
        'bootstrap.min.js',
        'js.cookie.min.js',
        'bootstrap-hover-dropdown.min.js',
        'jquery.slimscroll.min.js',
        'jquery.blockui.min.js',
        'jquery.uniform.min.js',
        'bootstrap-switch.min.js',
        'bootstrap-confirmation.min.js',
        'jquery.validate.min.js',
        'datatable.min.js',
		'datatable.js',
        'datatables.min.js',
        'datatables.bootstrap.js',
        'additional-methods.min.js',
        'toastr.min.js',
        'bootstrap-fileinput.js',
        'bootstrap-select.min.js',
        'app.min.js',
        'layout3.min.js',
        'jquery.calendars.js',
        'jquery.calendars.islamic.js',
        'jquery.calendars.plus.js',
        'jquery.plugin.min.js',
        'jquery.calendars.picker.js',
        'custom-front.js'
    ], paths.production.js + 'front.js', 'resources/assets/js');
    mix.scripts([
        'raphael-min.js',
        'morris.min.js',
        'amcharts.js',
        'pie.js',
        'light.js',
        'dataloader.min.js',
        'custom-chart.js'
    ], paths.production.js + 'charts.js', 'resources/assets/js');

    mix.scripts([
        'pace.min.js',
        'jquery.min.js',
        'jquery-ui.min.js',
        'bootstrap.min.js',
        'js.cookie.min.js',
        'bootstrap-hover-dropdown.min.js',
        'jquery.slimscroll.min.js',
        'jquery.blockui.min.js',
        'jquery.uniform.min.js',
        'bootstrap-switch.min.js',
        'bootstrap-confirmation.min.js',
        'jquery.validate.min.js',
        'additional-methods.min.js',
        'toastr.min.js',
        'bootstrap-fileinput.js',
        'bootstrap-select.min.js',
        'app.min.js',
        'layout.min.js',
        'login.min.js'
    ], paths.production.js + 'login.js', 'resources/assets/js');

    mix.scripts([
        'pace.min.js',
        'jquery.min.js',
        'jquery-ui.min.js',
        'bootstrap.min.js',
        'js.cookie.min.js',
        'bootstrap-hover-dropdown.min.js',
        'jquery.slimscroll.min.js',
        'jquery.blockui.min.js',
        'jquery.uniform.min.js',
        'bootstrap-switch.min.js',
        'bootstrap-confirmation.min.js',
        'jquery.validate.min.js',
        'additional-methods.min.js',
        'toastr.min.js',
        'bootstrap-fileinput.js',
        'bootstrap-select.min.js',
        'app.min.js',
        'jquery.calendars.js',
        'jquery.calendars.islamic.js',
        'jquery.calendars.plus.js',
        'jquery.plugin.min.js',
        'jquery.calendars.picker.js',
        'jquery.calendars.picker-ar.js',
        'jquery.calendars.islamic-ar.js',
        'layout.min.js',
        'jquery.dataTables.min.js',
        'custom.js',
        'custom-rtl.js'
    ], paths.production.js + 'app-rtl.js', 'resources/assets/js');

    mix.scripts([
        'jquery.min.js',
        'jquery-ui.min.js',
        'bootstrap.min.js',
        'js.cookie.min.js',
        'bootstrap-hover-dropdown.min.js',
        'jquery.slimscroll.min.js',
        'jquery.blockui.min.js',
        'jquery.uniform.min.js',
        'bootstrap-switch.min.js',
        'bootstrap-confirmation.min.js',
        'jquery.validate.min.js',
        'datatable.min.js',
        'additional-methods.min.js',
        'toastr.min.js',
        'bootstrap-fileinput.js',
        'bootstrap-select.min.js',
        'app.min.js',
        'layout3.min.js',
        'jquery.calendars.js',
        'jquery.calendars.islamic.js',
        'jquery.calendars.plus.js',
        'jquery.plugin.min.js',
        'jquery.calendars.picker.js',
        'jquery.calendars.picker-ar.js',
        'jquery.calendars.islamic-ar.js',
        'datatable.js',
        'datatables.min.js',
        'datatables.bootstrap.js',
        'custom-front.js',
        'custom-front-rtl.js'
    ], paths.production.js + 'front-rtl.js', 'resources/assets/js');
});