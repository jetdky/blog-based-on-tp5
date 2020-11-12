<?php

namespace app\index\model;

use think\Model;

class Category extends Model
{
    public function getCategoryList($num = 3)
    {   
        return $this->order('sort_number', 'desc')->limit($num)->select();
    }
}