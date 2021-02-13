const path = require('path');

module.exports = {
  entry: './assets/js/index.ts',
  entry: {
    main: './assets/js/index.ts',
    'sticky-sidebar': './assets/js/libraries/sticky-sidebar/sticky-sidebar.js'
  },
  output: {
    filename: '[name].min.js',
    path: path.resolve(__dirname, 'assets/dist/js')
  },
  module: {
    rules: [
      {
        test: /\.ts?$/,
        use: 'ts-loader',
        exclude: /node_modules/,
      },
    ],
  },
  resolve: {
    extensions: ['.ts', '.js'],
  },
};