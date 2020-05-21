<?php
/**
 * Name: EloquentModel.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/15
 * Time: 21:05
 */

namespace Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        
        /** @var object $capsule Eloquent ORM */
        $capsule = new Capsule;
        $capsule->addConnection(
            [
                'driver' => self::$db,
                'host' => self::$host,
                'database' => self::$db_name,
                'username' => self::$user,
                'password' => self::$pass,
                'charset' => self::$charset,
                'collation' => self::$charset . '_general_ci',
                'prefix' => '',
            ]
        );
        $capsule->bootEloquent();
    }
    
    public function index()
    {
    }
}