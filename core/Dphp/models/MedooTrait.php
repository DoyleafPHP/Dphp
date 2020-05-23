<?php
/**
 * Medoo.php on Dphp
 *
 * Code By ch4o5.
 * on 五月 21th/2020 at 20:07
 *
 * Powered By PhpStorm
 */

namespace Models;

use Generator;
use Medoo\Medoo;
use PDO;

/**
 * Medoo ORM的实现Trait
 * Trait Medoo
 *
 * @package Models
 *
 * @author  ch4o5.
 * create on 2020/5/21
 */
trait MedooTrait
{
    use ModelTrait;
    
    /**
     * 根据sql返回一次性但防内存溢出的结果集
     * 只能用于foreach遍历，一次性，不适用于其他操作
     *
     * @param string      $sql
     *
     * @param string|null $column    需要显示的字段
     * @param string|null $index_key 作为key的字段，不修改显示的字段时，$column置为null
     *
     * @return \Generator
     */
    public function yieldAllBySql(string $sql, ?string $column = null, ?string $index_key = null): Generator
    {
        $stat = $this->dMol()->query($sql);
        
        $i = 0;
        while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
            $key = !empty($index_key) && !empty($row[$index_key]) ? $row[$index_key] : $i;
            $value = !empty($column) && !empty($row[$column]) ? $row[$column] : $row;
            
            $i++;
            yield $key => $value;
        }
    }
    
    /**
     * D-Model-OnLine
     * 即连接数据库操作
     *
     * @return \Medoo\Medoo
     */
    protected function dMol(): Medoo
    {
        $this->initialize();
        
        return new Medoo(
            [
                'pdo' => self::$pdo,
                
                'prefix' => self::$prefix,
                'database_type' => self::$db,
                'logging' => true,
            ]
        );
    }
}