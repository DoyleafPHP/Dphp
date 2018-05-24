<?php

/**
 * 入口文件
 * Name: index.php-Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/29
 */

// 运行框架启动器
require_once '../core/Dphp/bootstrap.php';

// 加载调用了fast-route的route配置文件
require_once(ROOT . '/core/Dphp/route.php');