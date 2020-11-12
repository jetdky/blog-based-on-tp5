<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        ///字段名 => '规则1|规则2...'
        'username' => 'require|length:2,30|unique:user',
        'password' => 'require|min:6',
        'repassword' => 'require|confirm:password'
    ];
    
    protected $message = [
        //'字段名.规则名' => '报错信息'
        'username.require' => '用户名不能为空',
        'username.length' => '用户名长度非法',
        'username.unique' => '用户名已被占用',
        'password.require' => '密码不能为空',
        'password.min' => '密码太短',
        'repassword.require' => '确认密码不能为空',
        'repassword.confirm' => '两次密码不一致'
    ];
}