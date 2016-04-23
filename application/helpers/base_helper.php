<?php

/**
 * Response Json
 *
 * Javascript|Ajax|Json 交互响应JSON输出
 *
 * @param bool $status
 * @param string $message
 * @param mixed $data
 * @param string $callback 使用 Callback 则为 JSONP 形式回调
 */
function response($status, $message = '', $data = null, $callback = null)
{
    $output = array('status' => $status);

    if ($message != '') {
        $output['message'] = $message;
    }

    if ($data !== null) {
        $output['data'] = $data;
    }

    $json = json_encode($output, JSON_UNESCAPED_UNICODE);
    echo $callback ? $callback . '(' . $json . ')' : $json;
    exit;
}

/**
 * 返回正确格式的数字
 *
 * @param mixed $var
 * @return string
 */
function numval($var)
{
    if (ctype_digit($var)) {
        return $var;
    }

    if (preg_match('/(\d+)/', $var, $m)) {
        return $m[1];
    }

    return 0;
}

/**
 * @return string
 * 生成guid
 */
function guid()
{
    if (function_exists('com_create_guid')) {
        $uuid = com_create_guid();
    } else {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12)
            . chr(125);// "}"

    }
    return trim($uuid, '{}');
}

/**
 * 清理 HTML 中的 XSS 潜在威胁
 *
 * 千辛万苦写出来，捣鼓正则累死人
 *
 * @param string|array $string
 * @param bool $strict 严格模式下，iframe 等元素也会被过滤
 * @return mixed
 */
function clean_xss($string, $strict = true)
{
    if (is_array($string)) {
        return array_map('cleanXss', $string);
    }

    //移除不可见的字符
    $string = preg_replace('/%0[0-8bcef]/', '', $string);
    $string = preg_replace('/%1[0-9a-f]/', '', $string);
    $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);

    $string = preg_replace('/<meta.+?>/is', '', $string); //过滤 meta 标签
    $string = preg_replace('/<script.+?<\/script>/is', '', $string); //过滤 script 标签

    if ($strict) {
        $string = preg_replace('/<iframe.+?<\/iframe>/is', '', $string); //过滤 iframe 标签 1
        $string = preg_replace('/<iframe.+?>/is', '', $string); //过滤 iframe 标签 2
    }

    //过滤标签属性
    /* 因线上 5.3 不支持匿名函数调用，所以改用下方的 _cleanXssRemoveUnsafeAttr 函数
    $string = preg_replace_callback('/(\<\w+\s)(.+?)(?=( \/)?\>)/is', function($m) {
        //去除标签上的 on.. 开头的 JS 事件，以下一个 xxx= 属性或者尾部为终点
        $m[2] = preg_replace('/\son[a-z]+\s*\=.+?(\s\w+\s*\=|$)/is', '\1', $m[2]);

        //去除 A 标签中 href 属性为 javascript: 开头的内容
        if (strtolower($m[1]) == '<a ') {
            $m[2] = preg_replace('/href\s*=["\'\s]*javascript\s*:.+?(\s\w+\s*\=|$)/is', 'href="#"\1', $m[2]);
        }

        return $m[1].$m[2];
    }, $string);
    */
    $string = preg_replace_callback('/(\<\w+\s)(.+?)(?=( \/)?\>)/is', '_cleanXssRemoveUnsafeAttr', $string);

    $string = preg_replace('/(<\w+)\s+/is', '\1 ', $string); //过滤标签头部多余的空格
    $string = preg_replace('/(<\w+.*?)\s*?( \/>|>)/is', '\1\2', $string); //过滤标签尾部多余的空格

    return $string;
}

function _cleanXssRemoveUnsafeAttr($m)
{
    //去除标签上的 on.. 开头的 JS 事件，以下一个 xxx= 属性或者尾部为终点
    $m[2] = preg_replace('/\son[a-z]+\s*\=.+?(\s\w+\s*\=|$)/is', '\1', $m[2]);

    //去除 A 标签中 href 属性为 javascript: 开头的内容
    if (strtolower($m[1]) == '<a ') {
        $m[2] = preg_replace('/href\s*=["\'\s]*javascript\s*:.+?(\s\w+\s*\=|$)/is', 'href="#"\1', $m[2]);
    }

    return $m[1] . $m[2];
}

/**
 * 加解密函数
 *
 * @param string $string
 * @param string $operation ENCODE|DECODE
 * @param string $key
 * @param integer $expiry
 * @return string
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
    $ckey_length = 4;

    $key = md5($key ? $key : get_instance()->config->item('encryption_key'));
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}


/**
 * 获取客户端 IP 地址
 * @return string
 */
function ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP']; elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    elseif (!empty($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
    else $ip = '';
    preg_match('/[\d\.]{7,15}/', $ip, $ips);
    return !empty($ips[0]) ? $ips[0] : '';
}

/**
 * 写入日志
 *
 * @param string $flag
 * @param string $content
 * @param boolean $out 是否输出日志
 * @return void
 */
function writeLog($flag, $content, $out = false)
{
    $CI =& get_instance();

    //使用系统配置中的日志目录
    $logPath = $CI->config->item('log_path');
    $logPath || $logPath = APPPATH . 'logs/';
    $filename = $logPath . date('Y-m-d') . '/' . $flag . '.log';

    if (!is_dir(dirname($filename))) {
        $dir = dirname($filename);
        mkdir($dir, 0774, true) && chmod($dir, 0774);
    }

    $content = date('Y-m-d H:i:s') . ' --> ' . $content . "\r\n";

    $create = !is_file($filename);
    $fp = fopen($filename, 'a');

    $mark = 'wlog_' . uniqid(rand(0, 9999));
    $mark2 = $mark . '_2';
    $CI->benchmark->mark($mark);

    //获取写锁定
    do {
        $lock = flock($fp, LOCK_EX);
        $lock || usleep(5000); //0.005 秒间隔

        $CI->benchmark->mark($mark2);
        $elapsedTime = $CI->benchmark->elapsed_time($mark, $mark2);

    } while (!$lock && $elapsedTime < 5); //5 秒获取锁超时

    //获取锁成功则写入文件并释放锁
    if ($lock) {
        fwrite($fp, $content);
        flock($fp, LOCK_UN);
    }

    fclose($fp);

    $create && chmod($filename, 0664);

    if ($out) echo $content;
}


/**
 * 分页封装
 *
 * @param int $currengPage
 * @param array $config 分页配置，如： ['base_url'=>?, 'total_rows'=>?, 'per_page'=>?]
 * @return array
 */
function fpage($currengPage, $config = [])
{
    if (!isset($config['per_page'])) {
        $config['per_page'] = 10;
    }

    $CI =& get_instance();

    $CI->load->library('pagination');
    $CI->pagination->initialize($config);

    $currengPage = intval($currengPage);
    $currengPage < 1 && $currengPage = 1;
    $offset = ($currengPage - 1) * $config['per_page'];
    return [
        'page' => $currengPage,
        'offset' => $offset,
        'html' => $CI->pagination->create_links()
    ];
}