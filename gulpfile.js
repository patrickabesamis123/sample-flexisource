var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// Change laravel elixir public path
elixir.config.assetsPath = 'public/';

elixir(function(mix) {
  mix
    .styles(['public/css/compiled/custom.css'], 'public/css/minified/custom.min.css')
    .styles(['public/css/compiled/style.css'], 'public/css/minified/style.min.css')
    .styles(['public/css/compiled/style-employer.css'], 'public/css/minified/style-employer.min.css')
    .styles(['public/css/compiled/widget.css'], 'public/css/minified/widget.min.css')
    .scripts('public/js/ng/public/static.pages.js', 'public/js/minified/public/static.pages.min.js')
    .scripts(
      'public/js/ng/controllers/homepage.controller.js',
      'public/js/minified/controllers/homepage.controller.min.js',
    )
    .scripts(
      'public/js/ng/candidate/candidate--settings.js',
      'public/js/minified/candidate/candidate--settings.min.js',
    )
    .scripts(['public/js/ng/controllers/global.function.js'], 'public/js/minified/controllers/global.function.min.js')
    .scripts('public/js/ng/candidate/candidate.js', 'public/js/minified/candidate/candidate.min.js')
    .scripts(['public/js/ng/login/job-search.js'], 'public/js/minified/login/job-search.min.js')
    .scripts(['public/js/ng/login/job-listing.js'], 'public/js/minified/login/job-listing.min.js')
    .scripts(['public/js/ng/login/register.js'], 'public/js/minified/login/register.min.js')
    .scripts(['public/js/ng/public/company.js'], 'public/js/minified/public/company.min.js')
    .scripts(['public/js/ng/login/login.js'], 'public/js/minified/login/login.min.js')
    .scripts(['public/js/ng/employers/sidebar.js'], 'public/js/minified/employers/sidebar.min.js')
    .scripts(['public/js/ng/employers/settings.js'], 'public/js/minified/employers/settings.min.js')
    .scripts(['public/js/ng/employers/dashboard.js'], 'public/js/minified/employers/dashboard.min.js')
    .scripts(['public/js/ng/employers/teams.js'], 'public/js/minified/employers/teams.min.js')
    .scripts(['public/js/ng/employers_set-JS.js'], 'public/js/minified/employers_set-JS.min.js')
    .scripts(['public/js/ng/employers/teams.js'], 'public/js/minified/employers/teams.min.js')
    .scripts(['public/js/ng/employers/company.roles.js'], 'public/js/minified/employers/company.roles.min.js')
    .scripts(['public/js/ng/employers/create-role--build.js'], 'public/js/minified/employers/create-role--build.min.js')
    .scripts(['public/js/ng/employers/create-role--video.js'], 'public/js/minified/employers/create-role--video.min.js')
    .scripts(['public/js/ng/employers/create-role--preApp.js'], 'public/js/minified/employers/create-role--preApp.min.js')
    .scripts(['public/js/ng/employers/create-role--standard.js'], 'public/js/minified/employers/create-role--standard.min.js')
    .scripts(['public/js/ng/employers/create-role--team.js'], 'public/js/minified/employers/create-role--team.min.js')
    .scripts(['public/js/ng/employers/create-role--process.js'], 'public/js/minified/employers/create-role--process.min.js')
    .scripts(['public/js/ng/employers/create-role--notifications.js'], 'public/js/minified/employers/create-role--notifications.min.js')
    .scripts(['public/js/ng/employers/create-role--integration.js'], 'public/js/minified/employers/create-role--integration.min.js')
    .scripts(['public/js/ng/public/blog-post.js'], 'public/js/minified/public/blog-post.min.js')
    .scripts(['public/js/ng/public/blog-post-details.js'], 'public/js/minified/public/blog-post-details.min.js')
    .scripts(['public/js/ng/employers/company.edit.js'], 'public/js/minified/employers/company.edit.min.js')
    .scripts(['public/js/ng/employers/manage.talent.js'], 'public/js/minified/employers/manage.talent.min.js');

});
