const path = require('path');
const webpack = require('webpack');
const mix = require('laravel-mix');
// const cleanWebpack = require('clean-webpack-plugin');
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true;

mix
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/login/login.js', 'public/js/login')
  .js('resources/js/login/register.js', 'public/js/login')
  .js('resources/js/login/forgot.js', 'public/js/login')
  .js('resources/js/candidate/roleapplication/role-app.js', 'public/js/candidate')
  .sass('resources/sass/styles/style.scss', 'public/css/compiled/')
  .sass('resources/sass/app.scss', 'public/css')
    // .sass('resources/sass/custom-v1.scss', 'public/css')
  .sass('resources/sass/modules/candidate/candidate.scss', 'public/css')
  .sass('resources/sass/modules/main/registration.scss', 'public/css')
  .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/fonts/vendor/bootstrap')
  .copy('resources/images/Default-Header.png', 'public/images/Default-Header.png')
  .copy('resources/images/video-preload.gif', 'public/images/video-preload.gif')
  .copy('resources/images/footer-logo.png', 'public/images/footer-logo.png')
  .copy('resources/images/logo.png', 'public/images/logo.png')
  .sourceMaps()
  .disableNotifications();

if (mix.inProduction()) {
  mix.version();

  mix.extract([
    'vue',
    'vform',
    'axios',
    'vuex',
    'jquery',
    'popper.js',
    'vue-i18n',
    'vue-meta',
    'js-cookie',
    'bootstrap',
    'vue-router',
    'sweetalert2',
    'vuex-router-sync',
    '@fortawesome/fontawesome',
    '@fortawesome/vue-fontawesome',
  ]);
}

mix.webpackConfig({
  plugins: [
    /**
     * Temporarily removes this for now.
     * Matt and Pat still has resources that is store public/js that they used.
     */
    // new cleanWebpack(['./public/js']),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      axios: 'axios',
      moment: 'moment',
      alertify: 'alertifyjs',
    }),
  ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/js'),
    },
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
    publicPath: mix.config.hmr ? '//localhost:8080' : '/',
  },
});
