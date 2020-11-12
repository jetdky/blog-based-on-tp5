<?php

namespace app\admin\model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';
    public function getCategory()
    {
        return $this->field('id, category_name')
                ->order('sort_number', 'desc')
                ->select();
    }
    
    public function getCategoryList()
    {
        return $this->order('sort_number', 'desc')->select();
    }
}