<?php

namespace app\common\controller;

use think\Controller;

/**
 * 后台控制器的父类，实现对于登录状态的判断
 */
class IndexBase extends Controller
{
    public function _initialize()
    {
        $category = model('category')->getCategoryList();
        $this->assign('category',$category);
        $this->fetch('public/header');
    }
}