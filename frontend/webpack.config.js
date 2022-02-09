let isProduction = process.env.NODE_ENV === 'production'

const path        = require('path'),

      projectRoot = path.resolve(__dirname, '../'),

      { CleanWebpackPlugin } = require('clean-webpack-plugin'),
      MiniCSSExtractPlugin = require('mini-css-extract-plugin')

let config = {
  filename: isProduction ? '[name]_[hash]' : '[name]',
  isProduction: isProduction,
  paths: {
    assets: path.resolve(projectRoot, 'frontend'),
    dist: path.resolve(projectRoot, 'public/dist')
  }
}

let webpackConfig = {
  context: path.resolve(__dirname),
  entry: {
    theme: [
      path.resolve(config.paths.assets, 'scripts/theme.js'),
      path.resolve(config.paths.assets, 'styles/theme.scss')
    ]
  },
  mode: config.isProduction ? 'production': 'development',
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
          MiniCSSExtractPlugin.loader,
          { loader: 'css-loader', options: {sourceMap: config.isProduction} },
          { loader: 'sass-loader', options: {sourceMap: config.isProduction} },
        ]
      },
      {
        test: /(images|img)\/.+\.(jpe?g|png|svg|bmp|webp|ico)$/i,
        use: [
            { loader: 'file-loader', options: {name: `[path]${config.filename}.[ext]`, publicPath: '/dist'} }
        ]
      },
      {
        test: /(web)?fonts\/.+\.(eot|svg|woff2?|ttf)$/i,
        use: [
            { loader: 'file-loader', options: {name: `fonts/${config.cacheBusting}.[ext]`, publicPath: '/dist'} }
        ]
      }
    ]
  },
  output: {
    filename: `js/${config.filename}.js`,
    path: config.paths.dist,
    publicPath: `${path.basename(config.paths.dist)}`
  },
  plugins: [
    new CleanWebpackPlugin({cleanOnceBeforeBuildPatterns: ['**/*', '!.gitkeep']}),
    new MiniCSSExtractPlugin({filename: `css/${config.filename}.css`}),
  ]
}

if (config.isProduction) {
  const CssMinimizerPlugin = require('css-minimizer-webpack-plugin')

  webpackConfig.plugins.push(new CssMinimizerPlugin())
}

module.exports = webpackConfig
