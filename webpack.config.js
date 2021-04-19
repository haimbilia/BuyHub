const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const config = {
  entry: {
      main: ['./assets/js/main.js', './assets/css/main.scss'],
  },
  module: {
    rules: [
      {
        test: /\.css$/i,
        use: [MiniCssExtractPlugin.loader, 'css-loader'],
      },
    ],
  },
  output: {
      path: './assets/bundles/',
      filename: "pawan.min.js",
  },

  plugins: [
    new MiniCssExtractPlugin({
      // Options similar to the same options in webpackOptions.output
      // both options are optional
      filename: 'pawan.min.css',
      chunkFilename: '[id].css',
    })
      // ...
  ]
  // ...
}