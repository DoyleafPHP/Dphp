<?php

// 暂时搁置

/**
 * wafphp配置文件
 * waf.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/11/24
 */

return [
	'DEBUG_LEVEL'          => 'INFO',
	// debug等级，DEBUG、INFO、WARN、ERROR,为空时关闭debug
	'MODEL_TYPE'           => 'Redis',
	// Model模式，MEMCACHE为memcache模式保存，REDIS为redis模式保存，为获得最佳体验建议使用Redis模式
	'WHITE_LIST_LIFETIME'  => 300,
	// 全局白名单有效时间
	'BLACK_LIST_LIFETIME'  => 300,
	// 全局黑名单有效时间
	//Model配置
	'MODEL_CONFIG'         => [
		'host'     => '127.0.0.1',
		// 主机
		'port'     => '6379',
		// 端口
		'password' => '',
		// 密码，Redis模式下使用
		'pconnect' => true,
		// 是否启用长连接
		'lifetime' => 3 * 60,
		// 默认key有效时间
	],
	// 白名单规则,白名单规则优先于黑名单规则
	'WHITE_IP'             => [ '127.0.0.2' ],
	// 白名单IP，为范围时以半角"-"分隔，如：127.0.0.1-127.0.0.255
	// 白名单UA，支持正则
	'WHITE_UA'             => [
		'Baiduspider'            => '.*\.baidu\.com',
		'Baidu-YunGuanCe-SLABot' => '.*\.baidu\.com',
		'Googlebot'              => '.*\.(googlebot|google)\.com',
		'360Spider'              => '.*\.360\.cn',
		'360JK'                  => '.*',
		'Sosospider'             => '.*\.soso\.com',
		'Sogou web spider'       => '.*\.sogou\.com',
		'bingbot'                => '.*\.(bing|msn)\.com',
		'yahoo'                  => '.*\.yahoo\.(net|com)',
	],
	// 白名单UA，UA的正则=>DNS反向解析匹配的正则
	'WHITE_UA_IGNORE_CASE' => true,
	// 白名单UA忽略大小写
	'WHITE_UA_DNS_REVERSE' => false,
	// 白名单UA开启DNS反向解析，开启后UA在白名单中的IP将进行DNS反向解析认证，第一次响应耗时增加2、3s
	// 黑名单规则
	'BLACK_IP'             => [ '127.0.0.3' ],
	// 黑名单IP，为范围时以半角"-"分隔，如：127.0.0.1-127.0.0.255
	'BLACK_UA'             => [
		'sqlmap' => '',
	],
	// 黑名单UA，支持正则
	'BLACK_UA_IGNORE_CASE' => true,
	// 黑名单UA忽略大小写
	// 检测脚本列表，根据顺序执行脚本检测，true表示开启该脚本检测
	'SCRIPT_LIST'          => [
		'Robot'  => true,
		// 机器人检测脚本，已完成
		'Mysql'  => false,
		// SQL注入检测脚本，未完成
		'Xss'    => false,
		// Xss检测脚本，未完成
		'Upload' => false,
		// 上传检测脚本，未完成
	],
	// 机器人检测脚本配置
	'WAF_ROBOT_CONFIG'     => [
		'IP_START_CHALLENGE_TIMES'    => 10,
		// 同IP段开启挑战访问次数，在同IP段访问统计有效时间内访问次数超过设定值后开启挑战，为0时首次访问直接开启，该IP客户端段进入黑白名单后统计重置
		'IP_START_CHALLENGE_LIFETIME' => 60,
		// 同IP段访问统计有效时间
		'CHALLENGE_MODEL'             => 'proof-of-work',
		// 可选挑战模式：js（返回一段js挑战）、code（返回验证码挑战）、code-cn（返回中文验证码挑战）、proof-of-work(工作量证明挑战)
		'WHITE_LIST_TIMEOUT'          => 120,
		// 白名单失效时间，受全局session有效时间影响，session失效后白名单效用随之失效
		'IP_FAILURE_LIFETIME'         => 120,
		// 同IP挑战失败次数统计保留时间，超过时间后失败次数统计将重置，每次挑战失败重新计时
		'IP_FAILURE_LIMIT'            => 1000,
		// 同IP挑战失败上限次数，超过次数后将进入全局黑名单，若该IP有客户端成功则重置失败次数
		'CHALLENGE_AJAX'              => true,
		// 是否关闭ajax类型请求的挑战
		'AJAX_FLAG'                   => '',
		// 用于标识当前请求为ajax请求，客户端GET、POST请求携带此变量时将被作为ajax请求处理（JQUERY类库的请求可自动识别），为空时不启用私有ajax标识
		'VERIFY_CODE_LENGTH'          => 6,
		// 验证码类型挑战的验证码长度
	],
	// SQL注入检测脚本配置
	'WAF_MYSQL_CONFIG'     => [],
	// Xss检测脚本配置
	'WAF_XSS_CONFIG'       => [],
	// 上传检测脚本配置
	'WAF_UPLOAD_CONFIG'    => []
];
