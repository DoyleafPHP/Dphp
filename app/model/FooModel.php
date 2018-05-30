<?php
/**
 * Name: FooModel.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/15
 * Time: 20:48
 */

namespace app\model;

use models\DoctrineModel as Doctrine;

/**
 * 使用了Doctrine的模型
 * Class FooModel
 * @package app\model
 */
class FooModel extends Doctrine
{
    protected $id;
    protected $title;
    protected $content;

    public function index()
    {

    }
}