<?php

/**
 * 核心配置文件
 * Core\config.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/30
 */

// 加载用户自定义配置文件
$config = require CONF . 'config.php';
$config['error'] = require CONF . 'error.php';
$config['db'] = require CONF . 'db.php';
$config['waf_php'] = require CONF . 'waf.php';
$routeConfig = require CONF . 'route.php';
$commandConfig = require CONF . 'command.php';

// 过滤空值
$config = array_filter($config);


// 声明重要常量
define(
    'DEBUG',
    !empty($config['debug'])
);
define(
    'WAF',
    !empty($config['waf'])
);

// 替换waf配置中的开关
$config['waf_php']['WAF_ON'] = WAF;


if (IS_CLI) {
    set_error_handler('error_cli');
    set_exception_handler('exception_cli');
} elseif (!DEBUG) {
    // 关闭调试模式时的处理方式
    error_reporting(0);
    
    // 命令行的处理方式
    set_error_handler('error');
    set_exception_handler('exception');
}
