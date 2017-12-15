<?php

/**
 * 实例文件
 * indexController.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/11/24
 */

namespace App\Index\controller;

use Controllers\HomeController;

class IndexController extends HomeController
{
    public function actionIndex()
    {
        $titles = ['title1'=>'DoyleafPHP！','title2'=>'dphp'];

        $this->assign($titles);
        $this->assign('content','Hello,Dphp');

        $this->display();
    }
    
}
