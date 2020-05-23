<?php

/**
 * Controller.class.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/30
 */

namespace Controllers;

use ErrorException;

class Controller
{
    
    public $dMol;
    public $config;
    
    /**
     * 加载配置项
     */
    public function __construct()
    {
        $this->setConfig($GLOBALS['config']);
    }
    
    /**
     * 运行时修改配置
     *
     * @param mixed $config
     *
     * @return \Controllers\Controller
     */
    public function setConfig($config)
    {
        $this->config = array_replace_recursive(
            is_array($this->config)
                ? $this->config
                : (array)$this->config,
            $config
        );
        
        return $this;
    }
    
    /**
     * @param $action
     * @param $params
     *
     * @throws ErrorException
     */
    public function __call($action, $params)
    {
        if (DEBUG) {
            throw new ErrorException('访问的方法' . $action . '不存在！');
        } else {
            error();
        }
    }
    
    /**
     * 获取配置
     *
     * @return mixed
     */
    protected function getConf()
    {
        return $this->config;
    }
    
    /**
     * 重定向
     *
     * @param string $handler
     *
     * @return void
     */
    protected function redirect($handler)
    {
        if (is_file($handler)) {
            header("Location:{$handler}");
        } else {
            header("Location:/errors/404.html");
        }
    }
    
}
