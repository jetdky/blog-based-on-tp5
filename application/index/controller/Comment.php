<?php

namespace app\index\controller;

use app\common\controller\IndexBase;

class Comment extends IndexBase
{
    public function save()
    {
        $data = input('param.');
        $res = model('comment')->save($data);
        if ($res) {
            model('article')->where('id', $data['comment_id'])->setInc('comment_number');
            $this->success('评论成功',url('index/article/read', ['id' => $data['comment_id']]));
        } else {
            $this->error('添加失败',url('index/article/read', ['id' => $data['comment_id']]));
        }
    }
}