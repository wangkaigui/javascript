<?php 
// +----------------------------------------------------------------------
// | 关注回复
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zhaojie
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Controller\AdminBase;

class AttentionReplyController extends AdminBase{
	private $Config = null;
	private $model = null;
	
	protected function _initialize() {
		parent::_initialize();
		$this->Config = D('Common/Config');
		$configList = $this->Config->getField("varname,value");
		$this->assign('Site', $configList);
		$this->model = D('Admin/WpMemberPublic');
		if(! TOKEN){
			$this->error('token不能为空!',U('index/index'));
		}
	}
	
	public function index(){
		$addon_config = $this->model->where(array('token'=>TOKEN))->getField('addon_config');
		$addon_config = json_decode($addon_config,true);
		if (IS_POST) {
			if(!empty($_FILES['img_url']['name'])){
				$_POST['img_url'] = uplodes($_FILES['img_url']);
			}
			$_POST['time'] = time();
			$addon_config['Wecome'] = $_POST;
			$data['addon_config'] = json_encode($addon_config);
			$where['token'] = array('eq',TOKEN);
			
			$result=$this->model->where($where)->save($data);
				
	        if ($result>0) {
	            $this->success("操作成功！");
	        } else {
	                $error = $this->model->getError();
	                $this->error($error ? $error : '操作失败！');
	        }
	    } else {
	    	$this->assign('wecome',$addon_config['Wecome']);
	        $this->display('');
	    }
	}
	
}