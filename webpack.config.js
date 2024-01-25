const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .addEntry('app', './assets/styles/app.scss') // Ajustez le chemin ici
    .disableSingleRuntimeChunk()
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
