<?php
/**
 * Model.php on Dphp
 *
 * Code By ch4o5.
 * on 五月 22th/2020 at 21:13
 *
 * Powered By PhpStorm
 */

namespace Models;

/**
 * Class Model
 *
 * @package app\model
 *
 * @author  ch4o5.
 * create on 2020/5/22
 */
abstract class Model
{
    /** @var mixed 实例化的模型 */
    protected $model;
    
    public static function __callStatic($name, $arguments)
    {
        return __CLASS__;
    }
    
    /**
     * 实例化的Trait模型
     *
     * @return mixed
     *
     * @example
     */
    abstract protected function dModel();
    
    /**
     * 生成一个model实例
     * 模拟实例化
     *
     * @return mixed
     */
    abstract public static function new();
}