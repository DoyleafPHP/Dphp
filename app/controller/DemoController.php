<?php

/**
 * 实例文件
 * indexController.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/11/24
 */

namespace app\controller;

use app\model\Foo;
use app\model\FooMe;
use Controllers\ViewController;

class DemoController extends ViewController
{
    /**
     * @throws \ErrorException
     */
    public function actionDemo()
    {
        $array = Foo::all()->toArray();
        // $array = (new Foo())->getDates();
        $titles = ['title1' => 'DoyleafPHP！', 'title2' => 'dphp'];
        
        $this->assign('foo', $array);
        $this->assign($titles);
        $this->assign('content', 'Hello,Dphp');
        
        $this->display();
    }
    
    public function actionIndex()
    {
        // $model = FooMe::new();
        $m = new FooMe();
        
        $sql = <<<SQL
select * from d_foo;
SQL;
        
        $array = [];
        foreach ($m->yieldAllBySql($sql, null, 'id') as $key => $value) {
            $array[$key] = $value;
        }
        
        $titles = ['title1' => 'DoyleafPHP！', 'title2' => 'dphp'];
        
        $this->assign('foo', $array);
        $this->assign($titles);
        $this->assign('content', 'Hello,Dphp');
        
        $this->display();
    }
    
}
