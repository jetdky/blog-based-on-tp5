<?php

namespace app\admin\controller;

use think\Request;
use app\common\controller\AdminBase;

class Index extends AdminBase
{

    public function index()
    {
        $sql = "SELECT version() AS v";
        $version = db('admin')->query($sql)[0]['v'];
        return view('index/index', ['version' => $version]);
    }
}
