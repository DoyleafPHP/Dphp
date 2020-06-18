<?php

/**
 * 核心路由查找器
 * Name: route.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/18
 * Time: 13:54
 */

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Whoops\Exception\ErrorException as ErrorException;

use function FastRoute\simpleDispatcher;

/** @var object $dispatcher 导入配置中的路由规则 */
$dispatcher = simpleDispatcher(
    function (RouteCollector $r) {
        foreach ($GLOBALS['routeConfig'] as $key => $value) {
            if ($key) {
                // 分组路由
                $r->addGroup(
                    $key,
                    function (RouteCollector $r) use ($key, $value) {
                        routerConfigParser($r, $value, $key);
                    }
                );
            } else {
                // 单条路由
                routerConfigParser($r, $value);
            }
        }
    }
);

// 获取http传参方式和资源URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// 将url中的get传参方式（?foo=bar）剥离并对URI进行解析
if (false !== ($pos = strpos($uri, '?'))) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
$http_status = $routeInfo[0];

switch ($http_status) {
    // 路由格式未定义
    case Dispatcher::NOT_FOUND:
        if (!DEBUG) {
            error(404);
        } else {
            throw new ErrorException('未定义此路由或未在新建文件后使用composer dump-autoload');
        }
        break;
    /**
     * 请求的HTTP⽅法与配置的不符合
     * HTTP规范要求405 Method Not Allowed响应包含“Allow：”头，
     * 用以详细说明所请求资源的可用方法。
     * 使用FastRoute的应用程序在返回405响应时，
     * 应使用数组的第二个元素添加此标头。
     */
    case Dispatcher::METHOD_NOT_ALLOWED:
        
        $allowedMethods = $routeInfo[1];
        header('HTTP/1.1 405 Method Not Allowed');
        $allow = implode(',', $allowedMethods);
        
        header('Allow:' . $allow);
        $errorMsg = '请求方式非法，可使用的请求方式为：' . $allow;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            error(405, $errorMsg);
        } else {
            throw new ErrorException($errorMsg);
        }
        break;
    
    // 正常
    case Dispatcher::FOUND:
        [$http_status, $handler, $vars] = $routeInfo;
        
        // 解析和过滤控制器/方法
        $handler = trim($handler, '/');
        if (strpos($handler, '/') === false) {
            // 纯控制器（形如：class）
            $handler_list = [$handler, ''];
        } else {
            // 指定了控制器和操作（形如：class/action）
            $handler_list = explode('/', $handler);
        }
        [$controller, $action] = $handler_list;
        
        $action = $action !== '' ? $action : $GLOBALS['config']['default_action'] ?? 'index';
        if (isset($vars['action'])) {
            // 通过vars传入了action，则覆盖掉handler中的action（方便测试，应该没有安全隐患）
            $action = $vars['action'];
            unset($vars['action']);
        }
        $action = lcfirst(str_replace('action', '', $action));
        
        $_SESSION['route'] = [
            // 控制器不强制加Controller后缀
            'controller' => lcfirst(str_replace('Controller', '', $controller)),
            'action' => $action
        ];
        
        $class = '\app\controller\\' . ucfirst($controller);
        $method = 'action' . ucfirst($action);
        
        // 调用$handler和$vars
        call_user_func_array(
            [
                new $class(),
                $method
            ],
            [$vars]
        );
        break;
}


/**
 * 解析路由配置项
 *
 * @param \FastRoute\RouteCollector $r
 * @param array                     $route_list   路由配置列表
 * @param string                    $group_prefix 组前缀
 *
 * @throws \Whoops\Exception\ErrorException
 */
function routerConfigParser(RouteCollector &$r, array $route_list, string $group_prefix = ''): void
{
    // 逐条解析
    foreach ($route_list as $route_detail) {
        if (!is_array($route_detail) || count($route_detail) !== 3) {
            throw new ErrorException('路由配置文件格式错误');
        }
    
        // 解构赋值并分别处理
        [$method, $uri, $handler] = array_map(
            function ($value) {
                // 过滤空格
                return str_replace(' ', '', $value);
            },
            $route_detail
        );
    
        // 过滤组名前缀
        $group_prefix = trim($group_prefix, '/');
        
        
        /* Http方法 */
        // 转换为大写
        $method = strtoupper($method);
        
        
        /* 路由 */
        // 过滤子路由中的可选部分和参数部分，因为不会对本部分造成影响
        $pattern = '(\[.*?\]|\{.*?\})';
        $child_uri = preg_replace($pattern, '', $uri);
        // 空等同于/
        $child_uri = rtrim($child_uri, '/');
        $child_uri = $child_uri === '' ? '/' : $child_uri;
        
        
        /* 处理操作的句柄 */
        if ($handler === '/' || trim($handler, '/') === '') {
            // 未指定句柄（空等同于/）
            $class = parseClassName($child_uri, $group_prefix);
        } elseif (strpos(rtrim($handler, '/'), '/') === false) {
            // 只指定了类名
            $class = rtrim($handler, '/');
            $class = parseClassName($child_uri, $group_prefix, $class);
        } elseif (strpos(ltrim($handler, '/'), '/') === false) {
            // 只指定了方法
            $class = parseClassName($child_uri, $group_prefix);
            $action = ltrim($handler, '/');
        } else {
            // 指定了类名和方法（单条和组都适用）
            [$class, $action] = explode('/', $handler);
            $class = parseClassName($child_uri, $group_prefix, $class);
        }
        $action = $action ?? '';
        $handler = rtrim("{$class}/{$action}", '/');
        
        // 添加路由
        $r->addRoute($method, $uri, $handler);
    }
}

/**
 * 解析class
 *
 * @param string $child_uri    子路由
 * @param string $group_prefix 组前缀
 *
 * @param string $class        类名
 *
 * @return string
 */
function parseClassName(string $child_uri, string $group_prefix = '', string $class = ''): string
{
    // 已存在合法类名，则直接返回
    if ($class !== '~' && $class !== '') {
        return $class;
    }
    
    if ($group_prefix !== '') {
        // 分组路由
        $class = $group_prefix;
        $class .= $child_uri === '/'
            // 无子路由（等同于单条路由中的有子路由）
            ? ''
            // 有子路由
            : ucfirst($child_uri);
        return $class . 'Controller';
    } else {
        // 单条路由
        return ($child_uri === '/')
            // 无子路由（首页）
            ? ($GLOBALS['config']['default_controller'] ?? 'demoController')
            // 有子路由
            : ucfirst($child_uri) . 'Controller';
    }
}