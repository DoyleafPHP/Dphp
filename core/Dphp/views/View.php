<?php

/**
 * 模型首页
 * index.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/30
 */

namespace Views;

use ErrorException;

class View
{
    public static $params = [];

    public function __construct()
    {
    }

    /**
     * 渲染视图
     * @param   string $templete 模板名
     * @return  void
     * @throws ErrorException
     */
    public static function display($path)
    {
    	// TODO BUG
        // 读取自定义的模板文件
        $handle = $path.'.html';
        
        // 获取模板文件名，防止全路径
        $templete_arr = \explode('/', $path);
        $templete = \asort($templete_arr)[0];
        
        if (!file_exists($handle)) {
            throw new ErrorException("模板文件{$templete}.html不存在", 301);
        }
        $templeteContent = htmlspecialchars(file_get_contents($handle));
        $tempConReplace = $templeteContent;

        // 绑定变量
        foreach (self::$params as $key => $value) {
            if (\strstr($tempConReplace, '{$' . $key . '}')) $tempConReplace = str_replace('{$' . $key . '}', $value, $tempConReplace);
        }
        $assets = [
            'js/', 'css/', 'img/', 'fonts/'
        ];
        foreach ($assets as $key => $value) $tempConReplace = str_replace($value, $value, $tempConReplace);

        $tempConReplace_new = htmlspecialchars_decode($tempConReplace);

        // 写入缓存文件
        $cache_fileName = CACHE . "/{$templete}.html";
        
        $cache_dir = dirname($cache_fileName);
        if (!file_exists($cache_dir)) mkdir($cache_dir, 0777, true);

        file_put_contents($cache_fileName, $tempConReplace_new);

        echo $tempConReplace_new;
    }

    /**
     * 绑定变量
     * @param mixed $name
     * @param mixed $params
     * @return array
     */
    public static function assign($name, $params)
    {
        if (is_array($params)) {
            self::$params = array_merge(self::$params, $params);
        } else {
            self::$params[$name] = $params;
        }
        return self::$params;
    }
}
