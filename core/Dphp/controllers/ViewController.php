<?php

/**
 * 前台控制器
 * controllers\HomeController
 * HomeController.class.php - Dphp
 *
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/30
 */

namespace Controllers;

use ErrorException;
use Views\View;

class ViewController extends Controller
{
    
    /**
     * 渲染视图
     *
     * @param string $html
     *
     * @return void
     * @throws ErrorException
     */
    protected function display($html = '')
    {
        $route = $_SESSION['route'];
        $html = empty($html) ? $route['class'] . '/' . $route['action'] : $html;
        $template = strtolower(APP . '/view/' . $html . '.html');
        View::display($template);
    }
    
    /**
     * 绑定变量
     *
     * @param string|array $name 当$params为空时可以是值
     * @param mixed        $params
     *
     * @return void
     */
    protected function assign($name, $params = '')
    {
        $params = empty($params) ? $name : $params;
        View::assign($name, $params);
    }
    
}
