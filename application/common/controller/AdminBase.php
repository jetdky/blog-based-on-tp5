<?php

namespace app\common\controller;

use think\Controller;

/**
 * 后台控制器的父类，实现对于登录状态的判断
 */
class AdminBase extends Controller
{
    public function _initialize()
    {
        if(!session('?admin')){
            $this->error('请先登录', url('admin/admin/login'));
        }
    }
}