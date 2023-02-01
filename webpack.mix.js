const mix = require('laravel-mix');

mix.postCss('resources/css/main.css', 'public/css', [
    require('tailwindcss/nesting'),
    require('tailwindcss'),
  ])
  .sass('resources/sass/backend.scss', 'css/backend.css')
  .sass('resources/sass/frontend.scss', 'css/frontend.css')
  .js('resources/js/main.js', 'js/main.js');

mix.extract()
  .version()
  .setPublicPath('public')
  .options({
    autoprefixer: true,
    processCssUrls: false,
  })
  .disableSuccessNotifications();

if (!mix.inProduction()) {
  mix.webpackConfig({
      devtool: 'source-map',
    })
    .sourceMaps()
    .browserSync({
      open: 'external',
      host: 'php-itrac-dev.test',
      proxy: 'php-itrac-dev.test'
    })
}

mix.disableSuccessNotifications();
