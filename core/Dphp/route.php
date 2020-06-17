<?php

/**
 * 核心路由查找器
 * Name: route.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/18
 * Time: 13:54
 */

use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

/** @var object $dispatcher 导入配置中的路由规则 */
$dispatcher = simpleDispatcher(
    function (RouteCollector $r) {
        foreach ($GLOBALS['routeConfig'] as $key => $value) {
            if ($key) {
                $r->addGroup(
                    $key,
                    function (RouteCollector $r) use ($key, $value) {
                        foreach ($value as $k => $v) {
                            // 如果控制器配置项为空时，默认根据路由获取控制器
                            $r->addRoute(
                                $v[0],
                                $v[1],
                                substr($key, 1) . ucfirst(
                                    empty($v[2])
                                        ? $v[2] = substr($v[1], 1) . 'Controller'
                                        : $v[2]
                                )
                            );
                        }
                    }
                );
            } else {
                foreach ($value as $k => $v) {
                    $r->addRoute(
                        $v[0],
                        $v[1],
                        substr($v[2], 0, 1) === '/'
                            ? substr(
                            empty($v[2])
                                ? $v[2] = substr($v[1], 1) . 'Controller'
                                : $v[2],
                            1
                        )
                            : $v[2]
                    );
                }
            }
        }
    }
);

// 获取http传参方式和资源URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// 将url中的get传参方式（?foo=bar）剥离并对URI进行解析
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    // 使用未定义格式路由
    case FastRoute\Dispatcher::NOT_FOUND:
        if (!DEBUG) {
            error(404);
        } else {
            throw new \Whoops\Exception\ErrorException('未定义此路由或未在新建文件后使用composer dump-autoload');
        }
        break;
    /**
     * 请求的HTTP⽅法与配置的不符合
     * HTTP规范要求405 Method Not Allowed响应包含“Allow：”头，
     * 用以详细说明所请求资源的可用方法。
     * 使用FastRoute的应用程序在返回405响应时，
     * 应使用数组的第二个元素添加此标头。
     */
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:

        $allowedMethods = $routeInfo[1];
        header('HTTP/1.1 405 Method Not Allowed');
        $allow = implode(',', $allowedMethods);

        header('Allow:' . $allow);
        $errorMsg = '请求方式非法，可使用的请求方式为：' . $allow;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            error(405, $errorMsg);
        } else {
            throw new \Whoops\Exception\ErrorException($errorMsg);
        }
        break;

    // 正常
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $class = '\app\controller\\' . ucfirst($handler);
        $vars = $routeInfo[2];
        $action = 'action' . ucfirst(
                isset($vars['action'])
                    ? $vars['action']
                    : 'index'
            );
        unset($vars['action']);
        $_SESSION['route'] = [
            'class' => substr($handler, 0, strpos(strtolower($handler), 'controller')),
            'action' => strtolower(substr($action, 6))
        ];
        // ... 调用$handler和$vars
        call_user_func_array(
            [
                new $class(),
                $action
            ],
            $vars
        );
        break;
}