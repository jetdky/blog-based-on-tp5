<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

class User extends AdminBase
{
    public function index()
    {
        $userList = model('user')->getUserList();
        $this->assign('userList', $userList);
        return $this->fetch();
    }
    public function del($id)
    {
        $res = model('user')->destroy($id);
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    //该用户评论了哪些文章
    public function articles($id)
    {
        $articles = model('comment')->getCommentArticles($id);
        $user = model('user')->where('id', $id)->find();
        return view('', ['articles' => $articles, 'user' => $user]);
    }
}