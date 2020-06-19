<?php

namespace Services;

/**
 * 响应的服务类
 * Class ResponseService
 * @package Services
 */
class ResponseService extends Service
{
    /** @var string[] http状态码 */
    public const HTTP_CODE = [
        200 => '成功', // 查询单个或全部
        201 => '操作成功', // 创建或修改
        204 => '删除成功',
        206 => '查询成功', // 区间
        
        400 => '请求错误',
        401 => '未登录',
        403 => '无权访问',
        404 => '不存在的对象',
        406 => '请求格式错误',
        410 => '对象已被删除',
        422 => '验证失败',
        
        500 => '服务器异常'
    ];
    
    /**
     * 响应json格式
     *
     * @param array $data
     * @param int   $http_code
     */
    public function json(array $data, int $http_code = 200)
    {
        if (isset(self::HTTP_CODE[$http_code])) {
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $http_code . ' ' . self::HTTP_CODE[$http_code]);
            // 确保FastCGI模式下正常
            header('Status:' . $http_code . ' ' . self::HTTP_CODE[$http_code]);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' ');
            // 确保FastCGI模式下正常
            header('Status:' . $http_code . ' ');
        }
        $json = json_encode($data);
        exit($json);
    }
}