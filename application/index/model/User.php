<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';

    //添加场景下自动完成的内容
    protected $insert = [
        // 'user_photo' =>'',  写了这条，传了也是空
        // 'password' 修改器写了，不能在里面再写password，否则会二次加密
        // 'balance' =>500  字段已删除
    ];

    public function setPasswordAttr($value)
    {
        return md5($value);
    }
}
