<?php

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        ///字段名 => '规则1|规则2...'
        'category_name' => 'require|unique:category',
        'sort_number' => 'require'
    ];
    
    protected $message = [
        //'字段名.规则名' => '报错信息'
        'category_name.require' => '分类名为空',
        'category_name.unique' => '分类名已存在',
        'sort_number.require' => '优先级为空'
    ];
}