/**
 * Created by xiabin on 2016/4/16.
 */
// salute.js

var layer = require('layer-js');
window.$ = $;
layer.config({
    path: __BASE_URL__ + '/static/js/lib/layer/', //layer.js所在的目录，可以是绝对目录，也可以是相对目录
    extend: __BASE_URL__ + '/static/js/lib/layer/extend/layer.ext.js'
});

module.exports = layer;