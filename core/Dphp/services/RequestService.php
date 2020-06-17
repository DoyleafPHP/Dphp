<?php

namespace Services;

/**
 * 请求的服务类
 * Class RequestService
 * @package Services
 */
class RequestService extends Service
{
    /**
     * 获取Get方式传递的参数
     * @param string|null $name 如果指定了本参数，则返回指定的get值
     * @return array|mixed|null
     */
    public function get(?string $name = null)
    {
        $get = $_GET;
        unset($get['s']);
        // TODO 没过滤
        if (isset($name)) {
            return $get[$name] ?? null;
        }
        return $get;
    }

    /**
     * 获取Post方式传递的参数
     * @param string|null $name 如果指定了本参数，则返回指定的Post值
     * @return array|false|mixed|string|null
     */
    public function post(?string $name = null)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST'){
            return null;
        }

        // 获取Content-Type以判断如何取值
        $content_type = $_SERVER["CONTENT_TYPE"];
        switch ($content_type) {
            case 'application/json':
                $post = file_get_contents('php://input');
                $post = json_decode($post,true);
                break;
            case 'application/x-www-form-urlencoded':
            case 'multipart/form-data':
            default:
                $post = $_POST;
                break;
        }

        // 指定了参数名，如果是数组则尝试返回对应的值
        if (isset($name)) {
            return is_array($post)
                ? $post[$name] ?? null
                : null;
        }

        return $post;
    }

    /**
     * 获取Put方式传递的参数
     * @param string|null $name 如果指定了本参数，则返回指定的Put值
     * @return array|false|mixed|string|null
     */
    public function put(?string $name = null)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'PUT'){
            return null;
        }

        $put = file_get_contents('php://input');

        // 获取Content-Type以判断如何取值
        $content_type = $_SERVER["CONTENT_TYPE"];
        if ($content_type == 'application/json') {
            $put = json_decode($put, true);
        } else {
            parse_str($put, $put);
        }

        // 指定了参数名，如果是数组则尝试返回对应的值
        if (isset($name)) {
            return is_array($put)
                ? $put[$name] ?? null
                : null;
        }

        return $put;
    }
}