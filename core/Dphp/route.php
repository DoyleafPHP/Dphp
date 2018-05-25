<?php

/**
 * 核心路由查找器
 * Name: route.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/18
 * Time: 13:54
 */

use Controllers\ErrorController;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/** @var object $dispatcher 导入配置中的路由规则 */
$dispatcher = simpleDispatcher(function (RouteCollector $r) {
	foreach ( $GLOBALS['routeConfig'] as $key => $value ) {
		if ( $key ) $r->addGroup($key, function (RouteCollector $r) use ($key, $value) {
			foreach ( $value as $k => $v ) {
				// 如果控制器配置项为空时，默认根据路由获取控制器
				$r->addRoute($v[0], $v[1], substr($key, 1) . ucfirst(empty($v[2])
					                                                     ? $v[2] = substr($v[1], 1) . 'Controller'
					                                                     : $v[2]));
			}
		}); else
			foreach ( $value as $k => $v ) $r->addRoute($v[0], $v[1], substr($v[2], 0, 1) === '/'
				? substr(empty($v[2])
					         ? $v[2] = substr($v[1], 1) . 'Controller'
					         : $v[2], 1)
				: $v[2]);
	}
});

// 获取http传参方式和资源URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// 将url中的get传参方式（?foo=bar）剥离并对URI进行解析
if ( false !== $pos = strpos($uri, '?') ) $uri = substr($uri, 0, $pos);

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ( $routeInfo[0] ) {
	case FastRoute\Dispatcher::NOT_FOUND:
		ErrorController::show(404, 'Not Found');
		// 使用未定义路由格式
		break;
	case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$allowedMethods = $routeInfo[1];
		header('HTTP/1.1 405 Method Not Allowed');
		// ... 405 Method Not Allowed
		/**
		 * The HTTP specification requires that a405 Method Not Allowedresponse include theAllow:
		 * header to detail available methods for the requested resource.
		 * Applications using FastRouteshould use the second array element to add this header when relaying a 405 response.
		 * 请求的HTTP⽅法与配置的不符合
		 */
		break;
	case FastRoute\Dispatcher::FOUND:
		$handler = $routeInfo[1];
		$class = '\app\controller\\' . ucfirst($handler);
		$vars = $routeInfo[2];
		$action = 'action' . ucfirst(isset($vars['action'])
			                             ? $vars['action']
			                             : 'index');
		unset($vars['action']);
		$_SESSION['route'] = [
			'class'  => substr($handler, 0, strpos(strtolower($handler), 'controller')),
			'action' => strtolower(substr($action, 6))
		];
		// ... 调用$handler和$vars
		call_user_func_array([
			                     new $class,
			                     $action
		                     ], $vars);
		break;
}