<?php

namespace app\admin\controller;

use think\Request;
use app\common\controller\AdminBase;

class Category extends AdminBase
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $categoryList = db('category')->query(
            'SELECT `id`, `sort_number`, `category_name`, `created_at`, `updated_at`, `num` FROM `coding_category` AS  `f`
            LEFT JOIN
                (SELECT `category_id` , COUNT(`category_id`) as `num` FROM `coding_article` GROUP BY `category_id`) AS `s`
            ON `id` = `category_id`;');
        return view('', ['categoryList' => $categoryList]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add()
    {
        return view();
    }
    public function doadd()
    {
        $data = input('param.');
        $validata = validate('category');
        if (!$validata->check($data)) {
            $this->error($validata->getError());
        } else {
            $res = model('category')->save($data);
            if ($res) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        }
    }

    /**
     * 查看分类下文章
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function detail($id)
    {
        $detail = model('article')->getArticleListByCategory($id);
        $category = model('category')->where('id', $id)->find();
        return view('', ['detail' => $detail ,'category' => $category]);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $category = model('category')->where('id', $id)->find();
        return view('',['category' => $category]);
    }
    public function doedit()
    {
        $data = input('param.');
        $validata = validate('category');
        if (!$validata->check($data)) {
            $this->error($validata->getError());
        } else {
            $res = model('category')->isUpdate(true)->save($data);
            if ($res) {
                $this->success('更新成功');
            } else {
                $this->error('更新失败');
            }
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function del($id, $num=0)
    {
        if($num){
            $this->error('请先删除分类下所有文章');
        }else{
            $res = model('category')->destroy($id);
            if($res){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }
}
