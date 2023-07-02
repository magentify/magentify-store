const Encore = require('@symfony/webpack-encore');
const WebpackPwaManifest = require('webpack-pwa-manifest')
const WorkboxPlugin = require('workbox-webpack-plugin')

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enablePostCssLoader()
    .copyFiles({
        from: './assets',
        to: 'assets/[path][name].[ext]',
    })
    .addPlugin(
        new WebpackPwaManifest({
            name: 'Magentify',
            short_name: 'Magentify',
            start_url: '/',
            theme_color: '#EF4D48',
            background_color: '#EF4D48',
            display: 'standalone',
            filename: 'web-manifest.json',
            icons: [
                {
                    src: './assets/images/logo/icon-512x512.png',
                    sizes: [96, 128, 192, 256, 384, 512],
                },
            ],
        })
    )
    .addPlugin(
        new WorkboxPlugin.GenerateSW({
            // these options encourage the ServiceWorkers to get in there fast
            // and not allow any straggling "old" SWs to hang around
            clientsClaim: true,
            skipWaiting: true,
            swDest: '../service-worker.js',
        })
    )
;

module.exports = Encore.getWebpackConfig();
