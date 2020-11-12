<?php

namespace app\index\controller;

use app\common\controller\IndexBase;

use app\index\controller\Article;
class User extends IndexBase
{
    public function login()
    {
        $con = new Article;
        $readList = $con->getReadList();
        return view('',['readList' => $readList]);
    }

    public function doLogin()
    {
        $data = input('param.');
        // 校验验证码
        if (!captcha_check($data['captcha'])) {
            $this->error('验证码不对');
        }
        $user = db('user')
            ->field('id, username, nick_name, user_photo')
            ->where('username', $data['username'])
            ->where('password', md5($data['password']))
            ->find();
        if ($user) {
            session('user', $user);
            $this->success('登录成功', url('index/article/index'));
        } else {
            $this->error('登录失败', url('index/user/login'));
        }
    }

    public function register()
    {
        $con = new Article;
        $readList = $con->getReadList();
        return view('',['readList' => $readList]);
        return $this->fetch();
    }

    public function doRegister()
    {
        $data = input('param.');
        //验证码
        if (!captcha_check($data['captcha'])) {
            $this->error('验证码错误');
        }
        $file = request()->file('user_photo');
        if ($file) {
            $path = ROOT_PATH . 'public/static/portrait';
            $info = $file->move($path);
            //这里的文件名包含2019../19849845....jpg，所以会超过数据库中的长度
            if ($info) {
                $data['user_photo'] = toLinux($info->getSaveName());
            } else {
                $data['user_photo'] = '';
            }
        }
        //校验数据合法性
        $validate = validate('user');
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        } else {
            $res = model('user')
                ->allowField(true)
                ->save($data);
            if ($res) {
                $this->success('注册成功', url('index/user/login'));
            } else {
                $this->error('注册成功');
            }
        }
    }
    public function logout()
    {
        session('user', null);
        session('id', null);
        $this->redirect(url('index/user/login'));
    }

    /**
     * 编辑用户的个人信息
     *
     * @return void
     */
    public function edit()
    {
        $user = model('user')->where('id', session('user.id'))->find();
        return view('', ['user' => $user]);
    }

    public function doedit()
    {
        $data = input('param.');
        $file = request()->file('user_photo');
        if($file){
            $path = ROOT_PATH . 'public/static/portrait';
            $info = $file->move($path);
            if($info){
                $oldPath = $path . '/' . $data['origin_photo'];
                if(file_exists($oldPath)){
                    @unlink($oldPath);
                }
                $data['user_photo'] = toLinux($info->getSaveName());
            }
        }
        $validate = validate('user');
        if(!$validate->check($data)){
            $this->error($validate->getError());
        }else{
            $res = model('user')->isUpdate(true)->allowField(true)->save($data);
            if ($res) {
                $user = model('user')->where('id', session('user.id'))->find();
                session('user', $user);
                $this->success('更新成功');
            } else {
                $this->error('更新失败');
            }
        }
    }
}
