<?php

namespace Admin\Controller;

class AdministratorGroupController extends __Controller {

    protected $form = array(
        'title' => array(
            'title' => '组名称',
            'type' => 'text',
            'name' => 'title'
        ),
        'slug' => array(
            'title' => '别名',
            'type' => 'text',
            'name' => 'slug'
        )
    );

    public function index() {
        $this->title = $this->meta_title = '管理员用户组';
        parent::index();
    }

    public function add()
    {
        parent::add(); // TODO: Change the autogenerated stub
    }

    public function edit($id)
    {
        parent::edit($id); // TODO: Change the autogenerated stub
    }

    public function delete($id)
    {
        parent::delete($id); // TODO: Change the autogenerated stub
    }

    public function status($id, $value)
    {
        parent::status($id, $value); // TODO: Change the autogenerated stub
    }

    public function sort($id, $value)
    {
        parent::sort($id, $value); // TODO: Change the autogenerated stub
    }

    public function auth($id) {
        if(IS_POST) {
            $rules = I('post.rule');

            if(!is_array($rules) || empty($rules))
                $this->error('请选择权限规则后在提交。');

            $rules = array_unique($rules);
            $rules = join(',',$rules);

            $result = $this->model->where(array('id' => $id))->setField('rules',$rules);

            if($result === false)
                $this->error($this->model->getError());
            $this->success('授权成功。');
        }
        else {
            $this->title = '选择权限';

            $menus = D('AdminMenu')->tree();
            $this->assign('_menus_',$menus);

            $exists = $this->model->where(array('id' => $id))->getField('rules');
            if($exists) $exists = explode(',',$exists);
            $this->assign('exists',$exists);

            $this->assign('id',$id);
            $this->display();
        }
    }

    public function tree($items,$depth,$exists) {
        $this->assign('_items_',$items);
        $this->assign('depth',$depth);
        $this->assign('exists',$exists);
        $this->display('AdministratorGroup/tree');
    }
}