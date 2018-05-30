<?php

// 关闭报错，防止影响用户体验
error_reporting(0);

// 设定日志文件
define('LOG_FILENAME', 'log.txt');

//调用waf
waf();
/**
 * 防火墙，过滤敏感词
 * @return void
 */
function waf()
{
    // 不存在即PHP版本过低，则重写getallheaders()函数
    if (!function_exists('getallheaders')) {
        /**
         * 获取全部HTTP请求头信息
         * @return array 返回的结果与同名系统函数一致
         */
        function getallheaders()
        {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        }

    }

    // 获取get传递的参数
    $get = $_GET;
    // 获取post传递的参数
    $post = $_POST;
    // 获取cooie
    $cookie = $_COOKIE;
    // 获取全部HTTP请求头信息
    $header = getallheaders();
    // 获取所有上传的文件
    $files = $_FILES;
    // 获取访问者IP
    // $ip = $_SERVER["REMOTE_ADDR"];
    // 获取访问的HTTP方式
    // $method = $_SERVER['REQUEST_METHOD'];
    // 获取访问的文件名
    // $filepath = $_SERVER["SCRIPT_NAME"];

    //rewirte shell which uploaded by others, you can do more

    foreach ($_FILES as $key => $value) {
        $files[$key]['content'] = file_get_contents($_FILES[$key]['tmp_name']);

        file_put_contents($_FILES[$key]['tmp_name'], "virink");
    }

    unset($header['Accept']);//fix a bug

    // 构建输入数组
    $input = array("Get" => $get, "Post" => $post, "Cookie" => $cookie, "File" => $files, "Header" => $header);

    //deal with
    // 判断sql关键字
    $pattern = "select|insert|delete|and|or|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|dumpfile|sub|hex";
    // 判断PHP敏感词（写入/执行等）
    $pattern .= "|file_put_contents|fwrite|curl|system|eval|assert";
    $pattern .= "|passthru|exec|system|chroot|scandir|chgrp|chown|shell_exec|proc_open|proc_get_status|popen|ini_alter|ini_restore";
    $pattern .= "|`|dl|openlog|syslog|readlink|symlink|popepassthru|stream_socket_server|assert|pcntl_exec";
    // 将构建好的敏感词字典以“|”为分隔符，拆分为数组
    $vpattern = explode("|", $pattern);

    // 是否出现敏感词标识符，默认为否
    $bool = false;
    // 遍历构建好的输入数组进行过滤
    foreach ($input as $k => $v) {
        foreach ($vpattern as $value) {
            foreach ($v as $kk => $vv) {
                if (preg_match("/$value/i", $vv)) {
                    $bool = true;
                    logging($input);
                    endAll();
                    break;
                }
            }
            if ($bool) break;
        }
        if ($bool) break;
    }
}

/**
 * 记录日志的方法
 * @param array $var
 * @return void
 */
function logging($var)
{

    file_put_contents(LOG_FILENAME, "\r\n" . time() . "\r\n" . print_r($var, true), FILE_APPEND);

    // die() or unset($_GET) or unset($_POST) or unset($_COOKIE);
}

/**
 * 终止所有操作并清空内存
 * @return void
 */
function endAll()
{
    unset($_GET);
    unset($_POST);
    unset($_COOKIE);
    cleanSession();
    exit();
}

/**
 * 彻底清空session
 * @return void
 */
function cleanSession()
{
    // 初始化session.
    session_start();
    /*** 删除所有的session变量..也可用unset($_SESSION[xxx])逐个删除。****/
    $_SESSION = array();
    /***删除sessin id.由于session默认是基于cookie的，所以使用setcookie删除包含session id的cookie.***/
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    // 最后彻底销毁session.
    session_destroy();
}

