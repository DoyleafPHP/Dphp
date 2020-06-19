<?php
/**
 * ControllerCommand.php - admin.s
 * CREATE BY doylee
 * EDIT BY PhpStorm
 * ON 2020 6月 25th
 */

namespace Commands;

use Error;

/**
 * Class ControllerCommand
 *
 * @package Commands
 */
class ControllerCommand extends Command
{
    private const TYPE = [
        0 => '',
        1 => '\Controllers\\RestfulController',
        2 => '\Controllers\\ViewController',
    ];
    
    /**
     * 创建控制器
     *
     * @param array $params
     */
    public function create(array $params)
    {
        // 解析参数
        $name = ucfirst($params['name']);
        $type = self::TYPE[$params['type']];
        if ($type !== '') {
            $type = 'extends ' . $type;
        }
        $className = ucfirst($name);
        
        // 复制源文件到目标位置
        $content = file_get_contents(DPHP . 'views/templates/controller.php.example');
        $content = str_replace('{~className~}', $name, $content);
        $content = str_replace('{~classType~}', $type, $content);
        
        $path = APP . 'controller/' . $className . '.php';
        $line_num = file_put_contents($path, $content);
        if ($line_num > 0) {
            exec('composer dump-autoload');
            throw new Error('控制器自动生成成功，路径为：' . $path);
        } else {
            throw new Error('添加失败，请检查目录权限：' . $path);
        }
    }
    
    /**
     * createController方法的说明
     *
     * @return array
     */
    private function introCreate()
    {
        return [
            '创建控制器文件',
            'name' => [
                'string',
                '方法名',
                true
            ],
            'type' => [
                'enum[0/1/2]',
                '控制器类型（0：不指定，1：Restful API，2：视图控制器）',
                true
            ]
        ];
    }
    
}