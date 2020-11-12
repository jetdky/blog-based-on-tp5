<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//路由表达式    地址表达式
//register  index/user/register
Route::rule('register', 'index/user/register', 'get');
//若请求不符合，会提示xxx模块不存在 
Route::rule('doRegister', 'index/user/doRegister', 'post');
Route::get('login', 'index/user/login');
Route::post('doLogin', 'index/user/doLogin');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    // //article/ID   index/article/read/id
    // //地址生效了，但页面不动！因为article和前面一样，所以加载的还是原来的，所以把长的放前面【这是个坑】
    // 'article/:id' => [
    //     'index/article/read',
    //     ['method' => 'get'],
    //     ['id' => '\d+'],
    // ],
    // //路由表达式    地址表达式
    // //article   index/article/index
    // //查看生效前，先点击其他的地方
    // 'article' => [
    //     'index/article/index',
    //     ['method' => 'get']
    // ],

    //路由分组，把相同前缀的路由放在一起
    '[article]' =>[
        ':id' => [
            'index/article/read',
            ['method' =>'get'],
            ['id' => '\d+'],
        ],
        '/' => [
            'index/article/index',
            ['method' => 'get'],
        ],
    ],
];
