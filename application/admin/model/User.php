<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';
    /**
     * 查询后台用户列表
     *
     * @return void
     */
    public function getUserList()
    {
        return $this
            ->order('created_at', 'desc')
            ->paginate(5);
    }
}