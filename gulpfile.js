var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less(['exercises.less', 'app.less', 'trainings.less']);
    mix.styles(['app.css', 'exercises.css', 'trainings.css'], null, 'public/css');
    mix.coffee();
});
