var webpack = require('webpack');
var css_dir = __dirname + '/css';
var js_dir = __dirname + '/js';
var lib_dir = js_dir + '/lib';
var build_dir = __dirname + '/assets';
var base_url = "http://pro.pp.cn"
var CommonsChunkPlugin = require("webpack/lib/optimize/CommonsChunkPlugin");
//自定义"魔力"变量

module.exports = {
    entry: {
        demo1: js_dir + '/demo1/demo1.js',
        demo2: js_dir + '/demo2/demo2.js',
    },
    output: {
        filename: build_dir + '/[name].js'
    },
    externals: [
        require('webpack-require-http')
    ],
    module: {
        loaders: [
            {test: /\.css$/, loader: 'style-loader!css-loader'},
            {test: /\.(png|jpg)$/, loader: 'url-loader?limit=8192'}
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery"
        }),
        new webpack.DefinePlugin({
            __LOGIN_LIB_URL__: JSON.stringify("http://testlogin.pp.cc/static/js/lc-base.js"),
            __BASE_URL__: JSON.stringify(base_url)
        }),
        new CommonsChunkPlugin(build_dir + '/common/common.js')
    ],
    resolve: {
        alias: {
            'jquery': lib_dir + '/jquery-2.2.2.min.js',
            'js-dir': js_dir,
            'css-dir': css_dir,
            'layer-js': lib_dir + '/layer/layer.js',
            'helper': js_dir + '/helper/helper.js',
            'helper-dir': js_dir + '/helper',
            'jquery-ui': lib_dir + '/jquery-ui'
        }
    }

}
;