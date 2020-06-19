<?php
/**
 * Name: ErrorController.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2018/5/25
 * Time: 14:47
 */

namespace Controllers;

use ErrorException;
use Views\View;

class ErrorController
{
    private static $http_code = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out'
    ];
    
    /**
     * 加载显示错误页面
     *
     * @param $code
     * @param $msg
     *
     * @throws ErrorException
     */
    public static function show($code, $msg)
    {
        $msg = empty($msg)
            ? self::getMessage($code)
            : $msg;
        View::assign(
            [
                'code' => $code,
                'msg' => $msg
            ],
            [
                'code' => $code,
                'msg' => $msg
            ]
        );
        View::display(PUB . '/error');
        exit();
    }
    
    /**
     * 获取默认错误提示
     *
     * @param int $code 错误码
     *
     * @return string|null
     */
    private static function getMessage(int $code): ?string
    {
        self::$http_code = array_replace_recursive(self::$http_code, $GLOBALS['config']['error']);
        return self::$http_code[$code];
    }
    
    /**
     * 打印出错误信息和错误码
     *
     * @param string $message
     * @param int    $code
     */
    public static function print(string $message, int $code = 0)
    {
        $time = date('Y-m-d H:i:s');
        
        exit(
        <<<INFO

{$time}
[{$code}] {$message}


INFO
        );
    }
}