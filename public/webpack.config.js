var webpack = require('webpack');
var css_dir = __dirname + '/css';
var js_dir = __dirname + '/js';
var lib_dir = js_dir + '/lib';
var build_dir = __dirname + '/build';

var CommonsChunkPlugin = require("webpack/lib/optimize/CommonsChunkPlugin");
var uglifyJsPlugin = webpack.optimize.UglifyJsPlugin;

module.exports = {
    entry: {
        demo1: js_dir + '/demo1/demo1.js',
        demo2: js_dir + '/demo2/demo2.js',
    },
    output: {
        filename: build_dir+ '/[name].js'
    },
    module: {
        loaders:[
            { test: /\.css$/, loader: 'style-loader!css-loader' },
            { test: /\.(png|jpg)$/, loader: 'url-loader?limit=8192'}
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery"
        }),

        new CommonsChunkPlugin(build_dir +'/common/common.js')
    ],
    resolve: {
        alias: {
            'jquery': lib_dir +  '/jquery-2.2.2.min.js',
            'jquery-ui': lib_dir +  '/jquery-ui',
            'js-dir':js_dir
        }
    },
};