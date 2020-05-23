<?php
/**
 * FooMe.php on Dphp
 *
 * Code By ch4o5.
 * on 五月 21th/2020 at 20:23
 *
 * Powered By PhpStorm
 */

namespace app\model;

use Medoo\Medoo;
use Models\MedooTrait;
use Models\Model;

/**
 * Class FooMe
 *
 * @package app\model
 *
 * @author  ch4o5.
 * create on 2020/5/21
 */
class FooMe extends Model
{
    use MedooTrait;
    
    public function __construct()
    {
        $this->model = $this->dMol();
    }
    
    /**
     * @inheritDoc
     */
    public static function new(): Medoo
    {
        return (new FooMe())->model;
    }
    
    /**
     * @inheritDoc
     */
    protected function dModel()
    {
        return $this->dMol();
    }
}