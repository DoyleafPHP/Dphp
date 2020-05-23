<?php

/**
 * 主函数库
 * functions.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/30
 */

use Controllers\ErrorController;

/**
 * 打印输出，有类型输出
 *
 * @param mixed $params
 *
 * @return void
 */
function dump(...$params)
{
    echo '<div style="background:lightblue;">';
    echo '<pre>';
    var_dump(...$params);
    echo '</pre>';
    echo '</div>';
    echo "<hr/>";
}

/**
 * 打印输出并终止进程
 *
 * @param mixed $params
 *
 * @return void
 */
function dd(...$params)
{
    dump(...$params);
    exit(205);
}

/**
 * 获取变量定义时的变量名
 *
 * @param mixed $var
 * @param mixed $scope
 *
 * @return false|int|string
 */
function get_variable_name(&$var, $scope = null)
{
    if (null == $scope) {
        $scope = $GLOBALS;
    }
    $tmp = $var;
    $var = "tmp_exists_" . mt_rand(0, 9);
    $name = array_search($var, $scope, true);
    $var = $tmp;
    
    return $name;
}

/**
 * 不存在时的错误处理
 *
 * @param int|string $errno
 * @param string     $errstr
 *
 * @return void
 */
function error($errno = '', $errstr = '')
{
    $errstr = empty($errno)
        ? '系统繁忙，请稍后再试'
        : $errstr;
    $_SESSION['errno'] = $errno;
    $_SESSION['error'] = $errstr;
    try {
        ErrorController::show($errno, $errstr);
    } catch (ErrorException $e) {
    }
}

/**
 * 彻底清空session
 *
 * @return void
 */
function cleanSession()
{
    // 初始化session.
    session_start();
    /*** 删除所有的session变量..也可用unset($_SESSION[xxx])逐个删除。****/
    $_SESSION = [];
    /***删除sessin id.由于session默认是基于cookie的，所以使用setcookie删除包含session id的cookie.***/
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    // 最后彻底销毁session.
    session_destroy();
}
