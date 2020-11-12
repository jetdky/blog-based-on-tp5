<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

class Article extends AdminBase
{
    public function _initialize()
    {
        if (!session('?admin')) {
            $this->error('请先登录', url('admin/admin/login'));
        }
    }
    public function add()
    {
        //判断用户登录状态
        $categoryList = model('category')->getCategory();
        $this->assign('categoryList', $categoryList);
        return $this->fetch();
    }
    public function doAdd()
    {
        $articleDetail = input('param.');
        $file = request()->file('subject_picture');
        if ($file) {
            $path = ROOT_PATH . 'public/static/upload';
            $info = $file->move($path);
            if ($info) {
                $articleDetail['subject_picture'] = toLinux($info->getSaveName());
            } else {
                $articleDetail['subject_picture'] = '';
            }
        } else {
            $articleDetail['subject_picture'] = '';
        }
        $res = model('article')->addArticle($articleDetail);
        if ($res) {
            $this->success('添加成功');
        } else {
            $this->error('添加失败');
        }
    }
    public function index()
    {
        $articleList = model('article')->getAllArticle();
        $category = model('category')->getCategory();
        $this->assign('articleList', $articleList);
        $this->assign('category', $category);
        return $this->fetch();
    }

    //文章编辑列表
    public function edit()
    {
        $id = input('param.id');
        $categoryList = model('category')->getCategory();
        $articleDetail = model('article')->getArticleDetail($id);
        return view('', [
            'categoryList' => $categoryList,
            'articleDetail' => $articleDetail
        ]);
    }

    //进行文章编辑
    public function save()
    {
        $data = input('param.');
        $file = request()->file('subject_picture');
        if ($file) {
            $path = ROOT_PATH . 'public/static/upload';
            $info = $file->move($path);
            if ($info) {
                //删除原来的图片
                $old = $path . '/' . $data['original_pictrue'];
                if (file_exists($old)) { //若图片存在删除，@抑制错误
                    @unlink($old);
                }
                $data['subject_picture'] = toLinux($info->getSaveName());
            } else {
                $data['subject_picture'] = $data['original_pictrue'];
            }
        } else {
            $data['subject_picture'] = $data['original_pictrue'];
        } //不选图片则图片名和原来一样
        $res = model('article')->updateArticle($data['id'], $data);
        if ($res) {
            $this->success('更新成功', url('admin/article/index'));
        } else {
            $this->error('更新失败');
        }
    }
    //文章上线和下线切换
    public function toggleStatus()
    {
        $data = input('param.');
        $res = model('article')->toggleStatus($data);
        if ($res && $data['is_online'] == 1) {
            $this->success('上线成功');
        } elseif ($res && $data['is_online'] == 0) {
            $this->success('下线成功');
        } elseif (!$res && $data['is_online'] == 1) {
            $this->error('上线失败');
        } else {
            $this->error('下线失败');
        }
    }
    //删除文章
    public function del($id)
    {
        //可以引入model类使用静态方法删除，但model和controller名字相同，需要起其他的别名
        //ArticleModel::destroy($id)
        if (is_numeric($id) && $id > 0) {
            $res = model('article')->delArticle($id);
            if ($res) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('删除失败');
        }
    }
}
