const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

const entries = [
    'app',
    'login',
    'register',
    'home',
    'combo'
];

entries.forEach(e => {
    Encore.addEntry(e, `./assets/${e}.js`);
})

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')  
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .copyFiles({ from: './node_modules/jquery/dist', to: 'jquery/[path][name].[ext]', pattern: /jquery\.min\.js$/ })
    .enableSassLoader();

module.exports = Encore.getWebpackConfig();
