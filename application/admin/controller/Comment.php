<?php

namespace app\admin\controller;

use think\Controller;

class Comment extends Controller
{
    //评论详情页显示每篇文章下的评论
    public function read()
    {
        $data = input('param.');
        $id = $data['id'];
        $comments = model('comment')
                ->where('comment_type', 'Article')
                ->where('user_id', $data['user_id'])
                ->where('comment_id', $id)->paginate(5);
        return view('', ['data' => $data, 'comments' => $comments]);
    }
    public function del($id)
    {
        $res = model('comment')->destroy($id);
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}