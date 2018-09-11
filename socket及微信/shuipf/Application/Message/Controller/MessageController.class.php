<?php

/**
 * 后台评论管理Action
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
namespace Message\Controller;
use Common\Controller\AdminBase;

class MessageController extends AdminBase {

    public $setting;
    protected $db;

    public function _initialize() {
        parent::_initialize();
        $this->setting = F("Comments_setting");
        $this->db = M("Message");
        if (!$this->setting) {
            $this->setting = $this->db->comments_cache();
        }
    }

    //显示留言
    public function index(){
    	echo 1;exit;
        if (IS_POST) {
            $ids = I('post.ids');
            if (empty($ids)) {
                $this->error("没有信息被选择！");
            }
            if (false !== $this->db->delete($ids)) {
                $this->success("删除评论成功！");
            } else {
                $this->error($this->db->getError());
            }
        } else {
            $count = $this->db->count();
            $page = $this->page($count, 20);
            $data = $this->db->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "DESC"))->select();
            $this->assign("Page", $page->show('Admin'));
            $this->assign("data", $data);
            $this->display();
        }
    } 
    
    /**
     * 删除留言
     */
    public function delete() {
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

?>