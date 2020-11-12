<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        ///字段名 => '规则1|规则2...'
        'username' => 'require|unique:admin',
        'password' => 'require',
        'repassword' => 'require|confirm:password'
    ];
    
    protected $message = [
        //'字段名.规则名' => '报错信息'
        'username.require' => '用户为空',
        'username.unique' => '用户名已存在',
        'password.require' => '密码不能为空',
        'repassword.require' => '密码太短',
        'repassword.confirm' => '两次密码不一致'
    ];
}