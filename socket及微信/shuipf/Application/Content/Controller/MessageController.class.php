<?php

// +-------------------------------------------
// | 后台首页
// +-------------------------------------------
// | Copyright (c) 2012-2014 
// +-------------------------------------------
// | Author:  jie
// +-------------------------------------------

namespace Content\Controller;

use Common\Controller\AdminBase;

class MessageController extends AdminBase {

    protected $db;

    public function _initialize() {
        parent::_initialize();
        $this->db = M("Message");
    }

    //显示留言
    public function lists(){

            $count = $this->db->count();
            $page = $this->page($count, 20);
            $data = $this->db->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "DESC"))->select();
            $this->assign("Page", $page->show('Admin'));
            $this->assign("data", $data);
            $this->display();
    } 
    
    public function add(){
    	if(IS_POST){
	    	if($_POST['g'] == 'message'){
	    		$Message = M('message');
	    		unset($_POST['g']);
	    		$data = array(
	    			'name' =>$_POST['name'],
	    			'Phone'=>$_POST['phone'],
	    			'Email'=>$_POST['email'],
	    			'content'=>$_POST['content'],
	    			'inputtime'=>time()
	    		); 
	    		$rows = $Message->data($data)->add();
	    		if($rows){
	    			$this->success("留言成功",'index.php');
	    		}
	    	}else{
	    		echo 1;
	    	}
    	}else{
    		$this->error("请求数据不正常！","");
    	}
    }
    
    /**
     * 删除留言
     */
    public function del() {
        $id = I('get.id', 0, 'intval');
        if (!$id) {
            $this->error("参数有误！");
        }
        if (false !== $this->db->delete($id)) {
            $this->success("留言删除成功！");
        } else {
            $this->error("留言删除失败！");
        }
    }
}
