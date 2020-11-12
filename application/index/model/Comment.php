<?php

namespace app\index\model;

use think\Model;

class Comment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';
    protected $insert = [
        'user_id'
    ];
    public function setUserIdAttr()
    {
        return session('user.id');
    }

    public function postComment($data)
    {
        return $this->save($data);
    }

    public function getCommentsById($id)
    {
        return $this->morphMany('Comment', 'comment', 'Article')
                ->where('comment_id', $id)
                ->order('created_at', 'desc')
                ->paginate(3);
    }
    public function user()
    {
        return $this->belongsTo('user', 'user_id');
    }
}