<?php

namespace app\admin\model;

use think\Model;

class AdminRole extends Model
{
    public function getRoleList()
    {
        return $this->field('id, role_name')->select();
    }
}