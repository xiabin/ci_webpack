<?php
/**
 * Created by PhpStorm.
 * User: binxia3
 * Date: 2016/4/24 0024
 * Time: 12:13
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>webuploader上传demo</title>
    <script src="<?= $static_url ?>/js/lib/jquery-2.2.2.min.js"></script>
    <script src="<?= $static_url ?>/js/lib/webuploader/webuploader.js"></script>
    <script src="<?= $static_url ?>/assets/common/common.js"></script>
</head>
<body>
<style>
    .webuploader-container {
        position: relative;
    }
    .webuploader-element-invisible {
        position: absolute !important;
        clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
        clip: rect(1px,1px,1px,1px);
    }
    .webuploader-pick {
        position: relative;
        display: inline-block;
        cursor: pointer;
        background: #00b7ee;
        padding: 10px 15px;
        color: #fff;
        text-align: center;
        border-radius: 3px;
        overflow: hidden;
    }
    .webuploader-pick-hover {
        background: #00a2d4;
    }

    .webuploader-pick-disable {
        opacity: 0.6;
        pointer-events:none;
    }
</style>
<div id="uploader" class="wu-example">
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker" class="webuploader-container"><div class="webuploader-pick">选择文件</div><div id="rt_rt_1aemh39e7vr81cfqll95kk1a8a1" style="position: absolute; top: 0px; left: 0px; width: 88px; height: 34px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
        <button id="ctlBtn" class="btn btn-default">开始上传</button>
    </div>
</div>
<script src="<?= $static_url ?>/assets/demo3.js"></script>
</body>
</html>
