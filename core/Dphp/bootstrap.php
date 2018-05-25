<?php
/**
 * Name: Core\bootstrap.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/18
 * Time: 10:36
 */

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

define("ROOT", dirname(dirname(__DIR__)));
define("DPHP", ROOT . '/core/Dphp');

// 定义应用目录
define("APP", ROOT . '/app');

// 定义配置目录
define("CONF", ROOT . '/config');

// 定义核心文件目录
define('CORE', ROOT . '/core');
define("VENDOR", CORE . '/vendor');

// 定义开放给用户的公共目录
define('PUB', ROOT . '/public');
define('CACHE', PUB . '/caches');

// 加载composer自动加载文件
require_once(VENDOR . '/autoload.php');

// 加载配置文件
require_once(DPHP . '/config.php');

// 加载错误提示包Whoops
if (DEBUG) {
    $whoops = new Run;
    $whoops->pushHandler(new PrettyPageHandler);
    $whoops->register();
}

session_start();

// 加载waf检测
if (WAF){
    require_once DPHP . '/waf.php';
}

