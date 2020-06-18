<?php
/**
 * 路由配置文件
 * Name: route.php-Dphp
 * Author: lidongyun@shuwang-tech.com
 * Date: 2017/12/18
 * Time: 13:57
 */

return [
    [
        // 指向首页（配置中的默认控制器和操作、可选路由）
        [
            'GET',
            '[/]',
            ''
        ],
    
        // 指向adminController
        [
            'GET',
            '/admin',
            ''
        ],
    
        // 指向错误页面
        // [
        //     'GET',
        //     '/error/{code:\d+}',
        //     'demoController'
        // ],
    
        [
            'GET',
            '/user[/{action}]',
            'userController'
        ],
        /*['GET','/user/{id:\d+}/{name}','userController'],*/
    ],
    
    // 订单管理
    '/order' => [
        
        // 下单
        [
            'POST',
            '/{id:\d+}',
            '~'
        ]
    ],
    
    // 后台路由
    '/admin' => [
        
        // 指向admin
        // [
        //   'GET',
        //   '[/]',
        //   '~'
        // ],
        
        // 指向adminController
        // [
        //     'GET',
        //     '[/]',
        //     ''
        // ],
        
        // 指向adminUserController
        [
            'GET    ',
            '/user',
            ''
        ]
    ]
];