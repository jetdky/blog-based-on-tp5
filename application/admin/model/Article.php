<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updated_at';
    protected $createTime = 'created_at';
    protected $insert = [
        'admin_id'
    ];

    //修改器，与上面配合，发表文章时指定admin_id的值
    public function setAdminIdAttr()
    {
        return session('admin.id');
    }
    
    //获取器，将上线的状态码转化为具体的显示
    public function getIsOnlineAttr($value)
    {
        $status = [
            0 => '已下线',
            1 => '已上线'
        ];
        return $status[$value];
    }
    public function addArticle($data)
    {
        return $this->save($data);
    }

    //获得所有文章，每页5篇，时间降序
    public function getAllArticle($where = [])
    {
        $c = input('param.');
        //判断subject存在且不为空，给where赋值，逻辑为空回到主页
        if(isset($c['subject']) && $c['subject']){
            $where['subject'] = ['like', '%' . $c['subject'] . '%'];
        }
        //当传递分类的时候显示对应分类下的文章
        if(isset($c['category_id']) && $c['category_id']){
            $where['category_id'] = $c['category_id'];
        }
        //where有值则条件where，where默认为空
        return $this->where($where)
                    ->order('created_at', 'desc')
                    ->paginate(5, false, ['query' => $c]);
    }

    public function getArticleDetail($id)
    {
        return $this->where('id', $id)->find();
    }

    //文章信息更新
    public function updateArticle($id, $data)
    {
        return $this->allowField(true)->save($data, ['id' => $id]);
    }

    //文章状态切换
    public function toggleStatus($data)
    {
        return $this->isUpdate(true)->save($data);
    }
    //删除文章
    public function delArticle($id)
    {
        return $this->destroy($id);
    }

    public function author()
    {
        return $this->belongsTo('admin', 'admin_id');
    }
    public function category()
    {
        return $this->belongsTo('category', 'category_id');
    }

    //根据分类id获得文章
    public function getArticleListByCategory($id)
    {
        return $this->where('category_id', $id)->paginate(5);
    }
    
    //查询管理员发布的文章
    public function getArticleByAdmin($id)
    {
        return $this->where('admin_id', $id)->paginate(5);
    }
}