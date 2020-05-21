<?php
/**
 * waf Of Dphp
 * Copyright 2017 Doylee <dongyunli619@gmail.com>.
 */

use WAFPHP\WAFPHP;

// 可根据需求在调用时使用独立配置，默认使用配置文件中的配置
$wafConfig = WAFPHP::getCurrentConfig();
// 修改特定配置参数
$wafConfig = array_replace_recursive($wafConfig, $config['waf_php']);
// 以自定义配置启动WAFPHP
$wafPHP = WAFPHP::getInstance($wafConfig);
// 执行脚本检测
$wafPHP->runCheck();
