<?php

namespace app\index\controller;

use app\common\controller\IndexBase;

class Article extends IndexBase
{
    //获得阅读排行榜
    public function getReadList()
    {
        $readList = db('article')
            ->where('is_online', '=', 1)
            ->field(['id', 'subject', 'browse_times'])
            ->order('browse_times', 'desc')
            ->limit(5)
            ->select();
        return $readList;
    }


    // 获得最新排行榜
    public function getRecentList()
    {
        $recentList = db('article')
            ->where('is_online', '=', 1)
            ->field(['id', 'subject'])
            ->order('created_at', 'desc')
            ->limit(5)
            ->select();
        return $recentList;
    }

    public function index($category_id = 0)
    {
        if ($category_id) {
            $articleList = model('article')
                ->where('is_online', '=', 1)
                ->where('category_id', $category_id)
                ->order('created_at', 'desc')
                ->paginate(5);
        } else {
            $articleList = model('article')
                ->where('is_online', '=', 1)
                ->order('created_at', 'desc')
                ->paginate(5);
        }
        $readList = $this->getReadList();
        $recentList = $this->getRecentList();
        $this->assign('articleList', $articleList);
        $this->assign('readList', $readList);
        $this->assign('recentList', $recentList);
        return $this->fetch();
    }
    public function read()
    {
        $id = input('param.id');
        $bool = input('param.bool') ?? null;
        $page = input('param.page') ?? null;
        $articleModel = model('article');
        $commentModel = model('comment');
        //防止已下线的文章被访问
        if ($articleModel->find($id)->is_online) {
            //文章浏览量+1，获得文章详情
            if ($bool && $page == null) {
                $articleModel->where('id', $id)->setInc('browse_times');
            }
            $articleDetail = $articleModel::get($id);

            //获得具体文章的评论内容
            $comments = $commentModel->getCommentsById($id);

            //将id存入session给Comment模型中的修改器用，在评论时自动插入当前文章id
            session('id', $id);

            $readList = $this->getReadList();
            $recentList = $this->getRecentList();
            $this->assign('readList', $readList);
            $this->assign('recentList', $recentList);
            $this->assign('articleDetail', $articleDetail);
            $this->assign('comments', $comments);
            return $this->fetch();
        } else {
            $this->error('文章已下线', url('index/article/index'));
        }
    }
}
