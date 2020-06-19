<?php
/**
 * Command.php - admin.s
 * CREATE BY doylee
 * EDIT BY PhpStorm
 * ON 2020 6月 19th
 */

namespace Commands;

/**
 * Class Command
 *
 * @package Controllers
 */
class Command
{
    
    public function __construct()
    {
        $this->init();
    }
    
    /**
     * 生命周期——1. 初始化
     */
    protected function init()
    {
    }
    
    public function __call($name, $arguments)
    {
        $this->willMount($name, $arguments);
        // 说明
        // $introduce = $this->introParser($name);
        // if (empty($arguments)) {
        // foreach ($introduce)
        // }
        
        $actionName = $name;
        $this->$actionName($arguments);
        
        $this->didMounted($name, $arguments);
    }
    
    /**
     * 生命周期——2.即将挂载
     *
     * @param $name
     * @param $arguments
     */
    protected function willMount($name, $arguments)
    {
    }
    
    /**
     * 生命周期——3.挂载完成
     *
     * @param $name
     * @param $arguments
     */
    protected function didMounted($name, $arguments)
    {
    }
    
    public function __destruct()
    {
        $this->willDestroy();
    }
    
    /**
     * 生命周期——5. 即将销毁操作
     */
    protected function willDestroy()
    {
    }
    
    /**
     * 说明解析器
     *
     * @param string $name
     *
     * @return array
     */
    private function introParser(string $name): array
    {
        // 获取说明
        $intro = 'intro' . ucfirst($name);
        return $this->$intro();
    }
    
    /**
     * 参数验证器
     *
     * @param array $params
     * @param array $introduce
     */
    private function paramsValidator(array $params, array $introduce)
    {
    }
}