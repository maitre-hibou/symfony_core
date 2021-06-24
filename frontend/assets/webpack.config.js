(function () {
    'use strict';

    const   path = require('path'),
            { CleanWebpackPlugin } = require('clean-webpack-plugin'),
            CssMinimizerPlugin = require('css-minimizer-webpack-plugin'),
            MiniCssExtractPlugin = require('mini-css-extract-plugin'),
            config = require('./config');

    let webpackConfig = {
        context: path.resolve(__dirname),
        entry: {
            theme: [
                path.resolve(config.paths.assets, './scripts/theme.js'),
                path.resolve(config.paths.assets, './styles/theme.scss'),
            ]
        },
        mode: config.isProduction ? 'production' : 'development',
        module: {
            rules: [
                {
                    test: /\.js$/,
                    use: [
                        { loader: 'buble-loader', options: {objectAssign: 'Object.assign'} }
                    ]
                },
                {
                    test: /\.s[ac]ss$/i,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {loader: 'css-loader', options: {sourceMap: config.isProduction}},
                        {loader: 'sass-loader', options: {sourceMap: config.isProduction}}
                    ],
                },
                {
                    test: /(images|img)\/.+\.(jpe?g|png|svg|bmp|webp|ico)$/i,
                    use: [
                        {loader: 'file-loader', options: {name: `[path]${config.cacheBusting}.[ext]`, publicPath: '/dist'}}
                    ]
                },
                {
                    test: /(web)?fonts\/.+\.(eot|svg|woff2?|ttf)$/i,
                    use: [
                        {loader: 'file-loader', options: {name: `fonts/${config.cacheBusting}.[ext]`, publicPath: '/dist'}}
                    ]
                }
            ]
        },
        output: {
            filename: `js/${config.cacheBusting}.js`,
            path: config.paths.dist,
            publicPath: `${path.basename(config.paths.dist)}/`
        },
        plugins: [
            new CleanWebpackPlugin({cleanOnceBeforeBuildPatterns: ['**/*', '!.gitkeep']}),
            new MiniCssExtractPlugin({filename: `css/${config.cacheBusting}.css`}),
        ]
    }

    if (config.isProduction) {
        webpackConfig.plugins.push(
            new CssMinimizerPlugin
        );
    }

    module.exports = webpackConfig;
}())

