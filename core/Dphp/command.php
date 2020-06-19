<?php
/**
 * command.php - Dphp
 * CREATE BY doylee
 * EDIT BY PhpStorm
 * ON 2020 6月 19th
 */

// 获取命令行参数
$args = $argv;
unset($args[0]);
$args = array_values($args);


// 解析出三个变量：行为/参数/其他参数

if (empty($args[1])) {
    // 如果只有行为，则补全目标
    $args[1] = '.';
}

$params = [];
foreach ($args as $i => $arg) {
    if ($i >= 2) {
        $params[] = $arg;
        unset($args[$i]);
    }
}
[$behaviour, $target] = $args;

// 进一步解析vars（只允许成对出现，且名的形式为'--名'）
if (count($params) % 2 === 1) {
    throw new Error('未预期的参数个数', 0);
}

$keys = $values = [];
foreach ($params as $key => $param) {
    if ($key % 2 === 0) {
        $keys[$key / 2] = substr($param, 2);
    } else {
        $values[($key - 1) / 2] = $param;
    }
}
$params = array_combine($keys, $values);

// 加载别名
$commands = $GLOBALS['commandConfig'];

$target_list = $commands[$behaviour] ?? '';
if ($target_list !== '') {
    $detail = $target_list[$target] ?? '';
    if ($detail !== '') {
        [$controller, $action] = $detail;
        
        $action = explode('-', $action);
        $method = 'action';
        is_array($action) && array_walk(
            $action,
            function ($part) use (&$method) {
                $method .= ucfirst($part);
            }
        );
    }
}

$controller = $controller ?? '\app\controller\\' . ucfirst($behaviour);

call_user_func_array(
    [
        new $controller(),
        $method ?? 'action' . ucfirst($target)
    ],
    [$params]
);
