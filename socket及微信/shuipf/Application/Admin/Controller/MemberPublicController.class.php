<?php 
// +----------------------------------------------------------------------
// | 微信公众号管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zhaojie
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Controller\AdminBase;

class MemberPublicController extends AdminBase{
	private $Config = null;
	public $member_public = null;
	
	public function _initialize(){
		parent::_initialize ();
		$this->member_public = M('wp_member_public');
	}
	
	public function index(){}
	/**
	  * 公众号列表
	  */
	public function lists(){
		$where = array();
        $role_id = I('get.role_id', 0, 'intval');
        if ($role_id) {
            $where['role_id'] = $role_id;
            $menuReturn = array(
                'url' => U('Rbac/rolemanage'),
                'name' => '返回角色管理',
            );
            $this->assign('menuReturn', $menuReturn);
        }
		$l = M('wp_member_public');
		$lists = $l->limit('5')->select();
		$this->assign('wplist',$lists);
		$this->display();
	}
	
	/**
	  * 添加公众号
	  */
	public function add(){
		if(!empty($_POST)){
			if(!empty($_FILES)){
				$destination = $this->uplodes();
			}
			$_POST['headface_url'] = $destination;
			$_POST['token'] = MD5('admin'.time().rand(1000,9999));
			$result = $this->member_public->add($_POST);
			if($result){
				$this->success('添加成功',U('MemberPublic/lists'));
			}else{
				 $this->error('添加失败');
			}
		}
		$this->display();
	}
	
	/**
	  * 修改公众号
	  */
	public function edit(){
		$id = I('id');				//获取当前公众号ID
		$lists = $this->member_public->find($id);
		if(!empty($_POST))
		{
			$id = $_GET['id'];		//获取当前公众号ID
			if(!empty($_FILES))
			{
				$destination = $this->uplodes();
			}
			$_POST['headface_url'] = $destination;
			if($_POST['headface_url'] == null)
			{
				unset($_POST['headface_url']);
			}
			if($lists['token'] == null)
			{
				$_POST['token'] = MD5('admin'.time().rand(1000,9999));
			}
			else
			{
				unset($_POST['token']);
			}
			$result = $this->member_public->where("id= $id")->setField($_POST);
			//echo $this->member_public->getlastSql();exit;
			if($result)
			{
				$this->success('修改成功',U('MemberPublic/lists'));
			}
			else
			{
				 $this->error('修改失败');
			}
		}
		$this->assign('lists',$lists);
		$this->display();
	}
	
	/**
	  * 接口配置帮助
	  */
	public function help(){
		$id = I('id');
		$lists = $this->member_public->find();
		$this->assign('lists',$lists);
		$this->display();
	}
	
	/**
	  * 删除公众号
	  */
	public function delete(){
		$id = I('get.id');
        if (empty($id)) {
            $this->error("没有指定删除对象！");
        }
        //执行删除
        if (M('wp_member_public')->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error(D('Admin/User')->getErrorgetError()? : '删除失败！');
        }
	}
	
	/**
	  * 切换为当前公众号
	  */
	public function ching(){
		$id = $_POST['id'];
		$isuse = $_POST['isuse'];
		if($isuse == 0){
			$data=array('is_use'=>'1');
			$this->member_public->where("id!=$id")->setField('is_use','0');
			$result = $this->member_public->where("id=$id")->setField($data);
			echo "1";
		}else{
			$data=array('is_use'=>'0');
			$this->member_public->where("id=$id")->setField($data);
			echo "0";
		}
	}
	
	/**
	  * 图片上传
	  */
	 public function uplodes(){
		//print_r($_FILES["headface_url"]); 
		if(is_uploaded_file($_FILES['headface_url']['tmp_name'])){ 
		$upfile=$_FILES["headface_url"]; 
		//获取数组里面的值 
		$tmp = explode('.',$upfile["name"]);
		$name=time().rand('0','9999').'.'.$tmp['1'];//上传文件的文件名 
		$type=$upfile["type"];//上传文件的类型 
		$size=$upfile["size"];//上传文件的大小 
		$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径 
		//判断是否为图片 
		switch ($type){ 
		case 'image/pjpeg':$okType=true; 
		break; 
		case 'image/jpeg':$okType=true; 
		break; 
		case 'image/gif':$okType=true; 
		break; 
		case 'image/png':$okType=true; 
		break; 
		} 

		if($okType){ 
		/** 
		* 0:文件上传成功<br/> 
		* 1：超过了文件大小，在php.ini文件中设置<br/> 
		* 2：超过了文件的大小MAX_FILE_SIZE选项指定的值<br/> 
		* 3：文件只有部分被上传<br/> 
		* 4：没有文件被上传<br/> 
		* 5：上传文件大小为0 
		*/ 
		$error=$upfile["error"];//上传后系统返回的值 
		move_uploaded_file($tmp_name,'d/file/wx/'.$name); 
		$destination="/d/file/wx/".$name; 
		if($error==0){	
		    return $destination;
		//echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">"; 
		}elseif ($error==1){ 
			echo "超过了文件大小，在php.ini文件中设置"; 
		}elseif ($error==2){ 
		    echo "超过了文件的大小MAX_FILE_SIZE选项指定的值"; 
		}elseif ($error==3){ 
		    echo "文件只有部分被上传"; 
		}elseif ($error==4){ 
		    echo "没有文件被上传"; 
		}else{ 
		echo "上传文件大小为0"; 
		} 
		}else{ 
		    echo "请上传jpg,gif,png等格式的图片！"; 
		} 
		} 
	 }
}