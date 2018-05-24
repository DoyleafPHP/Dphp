<?php

/**
 * 实例文件
 * indexController.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/11/24
 */

namespace app\controller;

use app\model\Foo;
use Controllers\HomeController;

class DemoController extends HomeController
{
    /**
     * @throws \ErrorException
     */
    public function actionIndex()
    {
        $array = Foo::all()->toArray();
        $titles = ['title1' => 'DoyleafPHP！', 'title2' => 'dphp'];

        $this->assign('foo', $array);
        $this->assign($titles);
        $this->assign('content', 'Hello,Dphp');

        $this->display();
    }

}
