<?php

return [
    /*
    |-----------------------------------------------
    |默认角色
    |-----------------------------------------------
    |当使用内置辅助函数获取守卫实例时，如果没有指定角色，
    |会返回默认角色守卫
    |*/

    'defaults' => [
        'role' => 'user',
    ],

    /*
    |-----------------------------------------------
    |角色组
    |-----------------------------------------------
    |可定义多个角色
    |必填项: provider,每个角色拥有一个provider,用于生成
    |查询构造器查询用户
    |选填项:
    |input_key: 前端请求key,默认值为:bearer_token
    |storage_key: 缓存key,默认值为:bearer_token
    |hash: 如果为true,则使用hash加密验证令牌,false则不使用hash
    |expire: 过期值，为每个角色令牌设定过期值
    |*/

    'roles' => [
        'user'     => [
            'provider'    => 'users',
            'hash'        => true,
            'input_key'   => 'bearer_token',
            'storage_key' => 'bearer_token',
        ],
        'employee' => [
            'provider'    => 'users',
            'hash'        => true,
            'input_key'   => 'bearer_token',
            'storage_key' => 'bearer_token',
        ],
    ],

    /*
    |-----------------------------------------------
    |角色(模型)提供者
    |-----------------------------------------------
    |提供者和角色为一对一关系，如果有多个角色则要为每个角色
    |指定不同的提供者,比如 users => User::class,键名要与
    |与模型表一至，便于区分
    |
    */

    'providers' => [
        'users'     => App\Models\User::class,
        'employees' => App\Models\Employee::class,
    ],

    /*
    |-----------------------------------------------
    |存储方式
    |-----------------------------------------------
    |将令牌存储至redis缓存，更能加快用户认证响应
    |connect: 默认连接redis的默认库，如果你需要将缓存存放
    |至其它库,那么你可以在database.php文件中进行配置
    |throttle: 访问限制为1分钟60次
    */
    'storage'   => [
        'redis' => [
            'connect'  => 'default',
            'throttle' => 60,
        ],
    ],
];
