<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';

    public function setPasswordAttr($value)
    {
        return md5($value);
    }
    
    public function checkAdmin($user)
    {
        return $this::get([
            'username' => $user['username'],
            'password' => md5($user['password'])
        ]);
    }
    public function getAllAdmin()
    {
        return $this->field('id, username, nick_name, role_id, created_at')
                    ->select();
    }

    public function role()
    {
        return $this->belongsTo('admin_role', 'role_id');
    }

    public function getAdmin($id)
    {
        return $this->find($id);
    }

    public function updateAdmin($data)
    {
        return $this->allowField(true)->isUpdate(true)->save($data);
    }
    
    //新增管理员
    public function addAdmin($data)
    {
        return $this->allowField(true)->save($data);
    }
}