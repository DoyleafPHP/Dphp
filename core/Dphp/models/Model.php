<?php

/**
 * 模型核心类
 * Model.class.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/31
 */

namespace Models;

use PDO;

class Model
{
    
    public static $user;
    public static $pass;
    public static $host;
    public static $db_name;
    public static $charset;
    public static $db;
    public static $prefix;
    
    public function __construct()
    {
        $db = $GLOBALS['config']['db'];
        
        self::$user = $db['user'];
        self::$pass = $db['pass'];
        self::$host = $db['host'];
        self::$db_name = $db['db_name'];
        self::$charset = $db['charset'];
        self::$db = $db['db'];
        self::$prefix = $db['prefix'];
    }
    
    /**
     * D-Model-OnLine
     * 即连接数据库操作
     *
     * @return bool|\PDO
     */
    public static function dMol()
    {
        return self::Connection();
    }
    
    /**
     * 建立数据库链接
     *
     * @return PDO
     */
    private static function Connection()
    {
        $dsn = self::$db . ':host=' . self::$host . ';dbname=' . self::$db_name . ';charset=' . self::$charset;
        // 建立了长连接
        return new PDO($dsn, self::$user, self::$pass, [PDO::ATTR_PERSISTENT => true]);
    }
    
}
