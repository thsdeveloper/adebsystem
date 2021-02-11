const path = require('path');
const mix = require('laravel-mix');
mix.config.vue.esModule = true;

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sourceMaps();
if (mix.inProduction()) {
  mix.version();
}

mix.webpackConfig({
  // plugins: [
  // Removemos o menu aqui
  //     new BundleAnalyzerPlugin()
  // ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/js')
    }
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
  }
});
