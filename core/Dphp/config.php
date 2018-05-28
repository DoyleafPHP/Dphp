<?php

/**
 * 核心配置文件
 * Core\config.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/30
 */

// 加载用户自定义配置文件
$config = require_once CONF . '/config.php';
$config['error'] = require_once CONF . '/error.php';
$config['db'] = require_once CONF . '/db.php';
$config['waf_php'] = require_once CONF . '/waf.php';
$routeConfig = require_once CONF . '/route.php';

// 过滤空值
$config = array_filter($config);


// 声明重要常量
define('DEBUG', !empty($config['DEBUG'])
	? true
	: false);
define('WAF', !empty($config['WAF'])
	? true
	: false);

// 替换waf配置中的开关
$config['waf_php']['WAF_ON'] = WAF;


// 关闭调试模式时的处理方式
if ( !DEBUG ) error_reporting(0);
if ( !DEBUG ) set_error_handler("notFound");