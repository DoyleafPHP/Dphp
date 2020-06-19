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
    ob_start();
    var_dump(...$params);
    $info = ob_get_contents();
    ob_end_clean();
    
    echo IS_CLI ? $info : <<<HTML
<div style="background:lightblue;">
	<pre>{$info}</pre>
</div>
<hr/>
HTML;
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
    if (empty($params)) {
        die;
    }
    dump(...$params);
    die();
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
 * 正式环境的异常处理
 *
 * @param \Throwable $e
 *
 * @return void
 */
function exception(Throwable $e)
{
    $code = $e->getCode();
    $message = $e->getMessage();
    $message = empty($message)
        ? '系统繁忙，请稍后再试'
        : $message;
    $_SESSION['code'] = $code;
    $_SESSION['message'] = $message;
    try {
        ErrorController::show($code, $message);
    } catch (ErrorException $e) {
    }
}

/**
 * 正式环境的错误处理
 *
 * @param int    $code
 * @param string $message
 *
 * @return void
 */
function error(int $code, string $message)
{
    $message = empty($message)
        ? '系统繁忙，请稍后再试'
        : $message;
    $_SESSION['code'] = $code;
    $_SESSION['message'] = $message;
    try {
        ErrorController::show($code, $message);
    } catch (ErrorException $e) {
    }
}

/**
 * 命令行的异常处理
 *
 * @param \Throwable $e
 *
 * @return void
 */
function exception_cli(Throwable $e)
{
    $code = $e->getCode();
    $message = $e->getMessage();
    $message = empty($message)
        ? '系统繁忙，请稍后再试'
        : $message;
    $_SESSION['code'] = $code;
    $_SESSION['message'] = $message;
    ErrorController::print($message, $code);
}

/**
 * 命令行的错误处理
 *
 * @param int    $code
 * @param string $message
 *
 * @return void
 */
function error_cli(int $code, string $message)
{
    $message = empty($message)
        ? '系统繁忙，请稍后再试'
        : $message;
    $_SESSION['code'] = $code;
    $_SESSION['message'] = $message;
    ErrorController::print($message, $code);
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
