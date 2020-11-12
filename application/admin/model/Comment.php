<?php

namespace app\admin\model;

use think\Model;

class Comment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';

    /**
     * 根据用户id查询用户评论的文章
     *
     * @param int $id
     * @return void
     */
    public function getCommentArticles($id)
    {
        return $this->where('user_id', $id)
                ->where('comment_type', 'Article')
                ->group('comment_id')->select();
    }

    public function subject()
    {
        return $this->belongsTo('article', 'comment_id'); 
    }

    public function user()
    {
        return $this->belongsTo('user', 'user_id'); 
    }

}
