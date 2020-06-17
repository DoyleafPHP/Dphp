<?php

/**
 * Controller.class.php - Dphp
 * User: lidongyun@shuwang-tech.com
 * Date: 2017/8/30
 */

namespace Controllers;

use ErrorException;
use Services\RequestService;
use Services\ResponseService;

class Controller
{

    protected $dMol;
    /** @var array|null */
    protected $config;
    /** @var RequestService */
    protected $request;
    /** @var ResponseService */
    protected $response;

    /**
     * 加载配置项
     */
    public function __construct()
    {
        $this->setConfig($GLOBALS['config']);
        $this->request = new RequestService();
    }

    /**
     * 运行时修改配置
     *
     * @param mixed $config
     *
     * @return Controller
     */
    private function setConfig($config)
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
     * @param string|null $config_name 用逗号分隔层级
     * @return mixed
     */
    protected function getConf(?string $config_name=null)
    {
        if (isset($config_name)){
            // 多层级
            if (strpos($config_name,'.') > -1){
                $name_list = explode('.',$config_name);
                $name_list = array_filter($name_list);
                $config = $this->config;
                foreach ($name_list as $name){
                    $config = $config[$name];
                }
                return $config;
            }else{
                // 单层
                return $this->config[$config_name];
            }
        }

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
        header("Location:{$handler}");
        // if (is_file($handler)) {
        //     header("Location:{$handler}");
        // } else {
        //     header("Location:/errors/404.html");
        // }
    }

}
