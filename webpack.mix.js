const path = require('path')
const mix = require('laravel-mix')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix
  .js('resources/assets/js/app.js', 'public/js')
  .less('resources/assets/less/app.less', 'public/css')

  .sourceMaps()
  .disableNotifications()

if (mix.inProduction()) {
  mix.version()

  mix.extract([
    'vue',
    'vform',
    'axios',
    'vuex',
    'jquery',
    'vue-meta',
    'js-cookie',
    'bootstrap',
    'vue-router',
    'izitoast',
    'vuex-router-sync'
  ])
}

mix.webpackConfig(webpack => {
  return {
    plugins: [
      // new BundleAnalyzerPlugin()
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        _: 'lodash',
        IziToast: 'izitoast'
      })
    ],
    resolve: {
      extensions: ['.js', '.json', '.vue', '.less'],
      alias: {
        '~': path.join(__dirname, './resources/assets/js')
      }
    },
    output: {
      chunkFilename: 'js/[name].[chunkhash].js',
      publicPath: mix.config.hmr ? '//localhost:8080' : '/'
    }
  }
})
