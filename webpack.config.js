var path = require('path');

module.exports = {
  entry: './assets/js/index.js',
  entry: {
    main: './assets/js/index.js',
    'sticky-sidebar': './assets/js/libraries/sticky-sidebar/sticky-sidebar.js'
  },
  output: {
    filename: '[name].min.js',
    path: path.resolve(__dirname, 'assets/dist/js')
  },
  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  }
};