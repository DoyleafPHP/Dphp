<?php

/**
 * 模型核心类
 * Model.class.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/31
 */

namespace Models;

use PDO;

/**
 * 模型的基础trait
 * Trait Model
 *
 * @package Models
 */
trait ModelTrait
{
    /** @var string */
    public static $user;
    /** @var string */
    public static $pass;
    /** @var string */
    public static $host;
    /** @var string */
    public static $db_name;
    /** @var string */
    public static $charset;
    /** @var string */
    public static $db;
    /** @var string */
    public static $prefix;
    /** @var PDO */
    public static $pdo;
    /** @var bool */
    public static $persistent;
    
    public static function initialize()
    {
        $db = $GLOBALS['config']['db'];
        
        self::$user = $db['user'];
        self::$pass = $db['pass'];
        self::$host = $db['host'];
        self::$db_name = $db['db_name'];
        self::$charset = $db['charset'];
        self::$db = $db['db'];
        self::$prefix = $db['prefix'];
        self::$persistent = $db['persistent'];
        
        self::$pdo = self::connection();
    }
    
    /**
     * 建立数据库链接
     *
     * @return PDO
     */
    private static function connection(): PDO
    {
        $dsn = self::$db . ':host=' . self::$host . ';dbname=' . self::$db_name . ';charset=' . self::$charset;
        // 建立了长连接
        return new PDO($dsn, self::$user, self::$pass, [PDO::ATTR_PERSISTENT => self::$persistent]);
    }
    
    /**
     * D-Model-OnLine
     * 即连接数据库操作
     *
     * @return bool|\PDO
     */
    abstract public function dMol();
    
}