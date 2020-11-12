<?php

namespace app\index\controller;

use think\Controller;

use think\Db;

class Dbtest extends Controller
{
    public function index()
    {
        // $db = Db::table('coding_user');
        // $db = Db::name('user');
        $db = db('user');
        print_r($db);
    }
    //数据库添加操作
    public function add()
    {
        $db = Db::name('user');
        $user = [
            'username' => mt_rand(1, 100),
            'password' => md5('abc123'),
            'nick_name' => '',
            'user_photo' => '',
            'updated_at' => time(),
            'created_at' => time()
        ];
        $users = [
            [
                'username' => mt_rand(1, 100),
                'password' => md5('abc123'),
                'nick_name' => '',
                'user_photo' => '',
                'updated_at' => time(),
                'created_at' => time()
            ],
            [
                'username' => mt_rand(1, 100),
                'password' => md5('abc123'),
                'nick_name' => '',
                'user_photo' => '',
                'updated_at' => time(),
                'created_at' => time()
            ]
        ];
        // $res = $db->insert($user);
        $res = $db->insertAll($users);
        echo $res;
    }
    //数据库删除操作
    public function del()
    {
        $res = db('user')->delete(13);
        echo $res;
    }
    //数据库更新操作
    public function save()
    {
        // $res = db('user')
        //         ->where('id', '=', '1')
        //         ->update(['nick_name' => '哲']);

        // $res = db('user')
        //     ->where('id',1)
        //     ->setField('nick_name', '渣渣辉');

        $res = db('article')
            ->where('id', 1)
            ->setInc('browse_times');
        echo $res;
    }
    //数据库查询操作
    public function query()
    {
        // $user =db('user')->find(1);

        // $user = db('user')
        //     ->field(["username","password"])
        //     ->where('username', '=' , '张三丰')
        //     ->where('password', '=', md5('123'))
        //     ->find();

        $users = db('user')
            ->field(["id","username"])
            ->order("created_at", 'desc')
            ->limit(3)
            ->select();
        echo '<pre>';
        print_r($users);
        echo '</pre>';
    }
}
