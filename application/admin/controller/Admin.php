<?php

namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
{
    protected $beforeActionList = [
        'checkAdmin' => ['except' => 'login,dologin']
    ];
    /**
     * 校验管理员状态
     *
     * @return void
     */
    public function checkAdmin()
    {
        if (!session('?admin')) {
            $this->error('请先登录', url('admin/admin/login'));
        }
    }
    public function login()
    {
        return $this->fetch();
    }
    public function doLogin()
    {
        $data = input('param.');
        $v = $data['captcha'];
        if (!captcha_check($v)) {
            $this->error('验证码错误', url('admin/admin/login'));
        }
        $res = model('admin')->checkAdmin($data);
        if ($res) {
            session('admin', $res);
            if(isset($data['remember_me'])){
                cookie('admin', $data, 604800);
            }
            $this->success('登录成功', url('admin/index/index'));
        } else {
            $this->error('登录失败');
        }
    }
    public function logout()
    {
        session('admin', null);
        cookie('admin', null);
        return $this->redirect(url('admin/admin/login'));
    }

    public function index()
    {
        $adminList = model('admin')->getAllAdmin();
        return view('', ['adminList' => $adminList]);
    }

    public function edit($id)
    {
        $roleList = model('AdminRole')->getRoleList();
        $adminDetail = model('admin')->getAdmin($id);
        return view('', ['roleList' => $roleList, 'adminDetail' => $adminDetail]);
    }

    //管理员编辑的保存，更新信息后要更新session
    public function save()
    {
        $data = input('param.');
        $validate = validate('Admin');
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        } else {
            $file = request()->file('admin_photo');
            if ($file) {
                $path = ROOT_PATH . 'public/static/portrait';
                $info = $file->validate(['size'=>1567800,'ext'=>'jpg,png'])->move($path);
                if ($info) {
                    //删除原来的图片
                    $old = $path . '/' . $data['original_pictrue'];
                    if (file_exists($old)) { //若图片存在删除，@抑制错误
                        @unlink($old);
                    }
                    $data['admin_photo'] = toLinux($info->getSaveName());
                } else {
                    $this->error($file->getError());
                    $data['admin_photo'] = $data['original_pictrue'];
                }
            } else {
                $data['admin_photo'] = $data['original_pictrue'];
            } //不选图片则图片名和原来一样
            $res = model('admin')->updateAdmin($data);
            if ($res) {
                session('admin', $data);
                $this->success('更新成功', url('admin/admin/index'));
            } else {
                $this->error('更新失败');
            }
        }
    }
    //管理员删除
    public function del($id)
    {
        if (is_numeric($id) && $id < 0) {
            $this->error('删除失败');
        } else {
            $res = model('admin')->destroy($id);
            if ($res) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        }
    }

    //新增管理员
    public function add()
    {
        $roleList = model('AdminRole')->getRoleList();
        return view('', ['roleList' => $roleList]);
    }
    public function doAdd()
    {
        $data = input('param.');
        $validate = validate('Admin');
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        } else {
            $file = request()->file('admin_photo');
            if ($file) {
                $path = ROOT_PATH . 'public/static/portrait';
                $info = $file->move($path);
                if ($info) {
                    $data['admin_photo'] = toLinux($info->getSaveName());
                } else {
                    $data['admin_photo'] = '';
                }
            } else {
                $data['admin_photo'] = '';
            } //不选图片则图片名和原来一样

            $res = model('admin')->addAdmin($data);
            if ($res) {
                $this->success('新增成功', url('admin/admin/index'));
            } else {
                $this->error('新增失败');
            }
        }
    }
    //查看管理员发表的文章
    public function article($id)
    {
        $articleListOfAdmin = model('article')->getArticleByAdmin($id);
        $admin = model('admin')->getAdmin($id);
        return view('', ['articleListOfAdmin' => $articleListOfAdmin, 'admin' =>$admin]);
    }
}
