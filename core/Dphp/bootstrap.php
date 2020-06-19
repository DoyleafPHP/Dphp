<?php
/**
 * Name: Core\bootstrap.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/18
 * Time: 10:36
 */

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

define("ROOT", dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
define("DPHP", ROOT . 'core/Dphp' . DIRECTORY_SEPARATOR);

// 定义应用目录
define("APP", ROOT . 'app' . DIRECTORY_SEPARATOR);

// 定义配置目录
define("CONF", ROOT . 'config' . DIRECTORY_SEPARATOR);

// 定义核心文件目录
define('CORE', ROOT . 'core' . DIRECTORY_SEPARATOR);
define("VENDOR", CORE . 'vendor' . DIRECTORY_SEPARATOR);

// 定义开放给用户的公共目录
define('PUB', ROOT . 'public' . DIRECTORY_SEPARATOR);
define('CACHE', PUB . 'caches' . DIRECTORY_SEPARATOR);

// 是否命令行模式
define('IS_CLI', substr(PHP_SAPI_NAME(), 0, 3) === 'cli');

// 加载composer自动加载文件
require_once(VENDOR . 'autoload.php');

// 加载配置文件
require_once(DPHP . 'config.php');

// 加载错误提示包Whoops
if (DEBUG && !IS_CLI) {
    (new Run())->pushHandler(new PrettyPageHandler())->register();
}

session_start();

// 加载waf检测
if (WAF) {
    require_once DPHP . '/waf.php';
}


