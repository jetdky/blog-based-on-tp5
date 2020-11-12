<?php
namespace app\index\controller;

use app\index\model\User;
class Modeltest
{
    public function index()
    {   
        $u = model('User');
        echo '<pre>';
        print_r($u);
        echo '</pre>';
    }
    //模型增
    public function add()
    {
        $user = [
            'username' =>'model_' . mt_rand(1, 1000),
            'password' => md5('123'),
            'nick_name' => '',
            'user_photo' => '',
            'updated_at' => time(),
            'created_at' => time(),
        ];
        $users = [
            [
                'username' => mt_rand(1, 100),
                'password' => md5('123'),
                'nick_name' => '',
                'user_photo' => '',
                'updated_at' => time(),
                'created_at' => time()
            ],
            [
                'username' => mt_rand(1, 100),
                'password' => md5('123'),
                'nick_name' => '',
                'user_photo' => '',
                'updated_at' => time(),
                'created_at' => time()
            ]
        ];
        // $res = model('user')->saveAll($users);
        $res = User::create($user);
        echo '<pre>';
        print_r($res);
        echo '</pre>';
    }

    //模型删
    public function del()
    {
        // $res = User::destroy([
        //     'username' => '55'
        // ]);
        $res = User::destroy("18, 19");
        echo $res;
    }

    //模型改
    public function update()
    {
        $u = User::get(['username' => '张三']);
        // $u->nick_name = '好色的张三';
        // $u->created_at = time();
        // $res = $u->save();
        $data = [
            'id' => 10,
            'nick_name' => '调皮的詹丹',
            'updated_at' =>time()
        ];
        // $res = model('user')
        //     ->isUpdate(true)
        //     ->save($data);
        $res = User::update($data);
        echo '<pre>';
        print_r($res);
        echo '</pre>';
    }

    //模型查
    public function query()
    {
        $res = User::get(['username'=>'张三']);
        echo '<pre>';
        print_r($res->toArray());
        echo '</pre>';
    }
}