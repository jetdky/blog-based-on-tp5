<?php

namespace app\index\model;

use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';
    /**
     * 查看文章的作者
     *当前模型是Article
     * @return mixed
     */
    public function author()
    {
        //     当前模型文章    属于   哪个管理员
        return $this->belongsTo('Admin', 'admin_id');
        // 参数1 关联模型
        // 参数2 关联模型对应本模型的外键
        // 参数3 本模型对应外键的主键，若为id可以不写
    }
}