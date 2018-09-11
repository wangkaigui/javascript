<?php 
// +----------------------------------------------------------------------
// | 站点配置
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zhaojie
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Controller\AdminBase;

class ScratchController extends AdminBase{
	private $Config = null;
	private $model = null;
	
	protected function _initialize() {
		parent::_initialize();
		$this->Config = D('Common/Config');
		$configList = $this->Config->getField("varname,value");
		$this->assign('Site', $configList);
		$this->model = D('Admin/WpScratch');
	}
	
	public function index(){
		$this->display();
	}
	
	//列表显示
	public function scratchlists(){
		$where['token']= array('eq',TOKEN);  //后期根据token查询
		if(!empty($_REQUEST ['keyword'])){
			$where['keyword'] = array (
					'like',
					'%'.htmlspecialchars($_REQUEST ['keyword']).'%' 
			);
		}
		$count = $this->model->count();
		$page = $this->page($count, 20);
		$list = $this->model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array('cTime' => 'DESC'))->select();
		$this->assign("Page", $page->show());
		$this->assign("list", $list);
		$this->display();
	}
	
	//增加
	public function add(){
		if (IS_POST) {
			$_POST['token'] = TOKEN;
			if(!empty($_FILES['cover']['name'])){
				$_POST['cover'] = uplodes($_FILES['cover']);
			}
			if(!empty($_FILES['end_img']['name'])){
				$_POST['end_img'] = uplodes($_FILES['end_img']);
			}
	        if ($this->model->createScratch($_POST)) {
	            $this->success("添加成功！", U('Scratch/scratchlists'));
	        } else {
	                $error = $this->model->getError();
	                $this->error($error ? $error : '添加失败！');
	        }
	    } else {
	        $this->display();
	    }
	}
	//编辑信息
	public function edit() {
		$id = I('request.id', 0, 'intval');
		if (empty($id)) {
			$this->error("请选择需要编辑的信息！");
		}
		if (IS_POST) {
			if(!empty($_FILES['cover']['name'])){
				$_POST['cover'] = uplodes($_FILES['cover']);
			}
			if(!empty($_FILES['end_img']['name'])){
				$_POST['end_img'] = uplodes($_FILES['end_img']);
			}
			
			if (false !== $this->model->amendScratch($_POST)) {
				$this->success("更新成功！", U('Scratch/scratchlists'));
			} else {
				$error = $this->model->getError();
				$this->error($error ? $error : '修改失败！');
			}
		} else {
			$data = $this->model->find($id);
			if (empty($data)) {
				$this->error('该信息不存在！');
			}
			$this->assign("data", $data);
			$this->display();
		}
	}	

	//删除
	public function del() {
		$id = $_REQUEST ['id'];
		if (empty($id)) {
			$this->error("没有指定删除对象！");
		}
		$where['id'] =array('in',$id); 
		//执行删除
		if ($this->model->where($where)->delete($id)) {
			$this->success("删除成功！");
		} else {
			$this->error($this->model->getError()? : '删除失败！');
		}
	}
	
	
	
	function preview() {
		$this->show ();
	}
	function show() {
		$id = $map ['target_id'] = I ( 'id' );
		
		$data = M ( 'wp_scratch' )->find ( $id );
		$this->assign ( 'data', $data );
		// dump($data);
		// 奖项
		$map ['addon'] = 'Scratch';
		$prizes = M ( 'wp_prize' )->where ( $map )->select ();
		$this->assign ( 'prizes', $prizes );
		
		// 抽奖记录
		$all_prizes = M ('wp_sn_code')->join("jbr_user ON jbr_user.id=jbr_wp_sn_code.uid")->where ( $map )->order ( 'jbr_wp_sn_code.id desc' )->select ();
		// dump ( $all_prizes );
		foreach ( $all_prizes as $all ) {
			if ($all ['prize_id'] > 0) {
				$has [$all ['prize_id']] += 1; // 每个奖项已经中过的次数
				$new_prizes [] = $all; // 最新中奖记录
				$all ['uid'] == session('jbr_admin_id') && $my_prizes [] = $all; // 我的中奖记录
			} else {
				$no_count += 1; // 没有中奖的次数
			}
			
			// 记录我已抽奖的次数
			$all ['uid'] == session('jbr_admin_id') && $my_count += 1;
		}
		
		$this->assign ('new_prizes', $new_prizes);
		$this->assign ('my_prizes', $my_prizes );
		// dump ( $new_prizes );
		// dump ( $my_prizes );
		
		// 权限判断
		unset ( $map );
		$map ['token'] = TKOEN;
		//$map ['openid'] = get_openid ();//后期写活
		$follow = M ('wp_follow')->where ($map)->find ();
		$error = '';
		if ($data ['end_time'] <= time ()) {
			$error = '活动已结束';
		} else if ($data ['max_num'] > 0 && $data ['max_num'] <= $my_count) {
			$error = '您的刮卡机会已用完啦';
		} else if ($data ['follower_condtion'] > intval ( $follow ['status'] ) && ! $is_admin) {
			switch ($data ['follower_condtion']) {
				case 1 :
					$error = '关注后才能参与';
					break;
				case 2 :
					$error = '用户绑定后才能参与';
					break;
				case 3 :
					$error = '领取会员卡后才能参与';
					break;
			}
		} else if ($data ['credit_conditon'] > intval ( $follow ['score'] ) && ! $is_admin) {
			$error = '您的财富值不足';
		} else if ($data ['credit_bug'] > intval ( $follow ['score'] ) && ! $is_admin) {
			$error = '您的财富值不够扣除';
		} else if (! empty ( $data ['addon_condition'] )) {
			$this->addon_condition_check( $data ['addon_condition'] ) || $error = '您没权限参与';
		}
		$this->assign ( 'error', $error );
		// 抽奖算法
		empty ( $error ) && $this->_lottery ( $data, $prizes, $new_prizes, $my_count, $has, $no_count );
		
		$this->display ( 'show' );
	}
	
	
	// 抽奖算法 中奖概率 = 奖品总数/(预估活动人数*每人抽奖次数)
	function _lottery($data, $prizes, $new_prizes, $my_count = 0, $has = array(), $no_count = 0) {
		$max_num = empty ( $data ['max_num'] ) ? 1 : $data ['max_num'];
		$count = $data ['predict_num'] * $max_num; // 总基数
		// 获取已经中过的奖
		foreach ( $prizes as $p ) {
			$prizesArr [$p ['id']] = $p;
				
			$prize_num = $p ['num'] - $has [$p ['id']];
			for($i = 0; $i < $prize_num; $i ++) {
				$rand [] = $p ['id']; // 中奖的记录，同时通过ID可以知道中的是哪个奖
			}
		}
		// dump ( $rand );
		// dump ( $prizesArr );
	
		if ($data ['predict_num'] != 1) {
			$remain = $count - count ( $rand ) - $no_count;
			$remain > 5000 && $remain = 5000; // 防止数组过大导致内存溢出
			for($i = 0; $i < $remain; $i ++) {
				$rand [] = 0; // 不中奖的记录
			}
		}
		if (empty ( $rand )) {
			$rand [] = - 1;
		}
	
		shuffle ( $rand ); // 所有记录随机排序
		$prize_id = $rand [0]; // 第一个记录作为当前用户的中奖记录
		$prize = array ();
	
		if ($prize_id > 0) {
			$prize = $prizesArr [$prize_id];
		} elseif ($prize_id == - 1) {
			$prize ['id'] = 0;
			$prize ['title'] = '奖品已抽完';
		} else {
			$prize ['id'] = 0;
			$prize ['title'] = '谢谢参与';
		}
	
		// 获取我的抽奖机会
		if (empty ( $data ['max_num'] )) {
			$prize ['count'] = 1;
		} else {
			$prize ['count'] = $max_num - $my_count - 1;
			$prize ['count'] < 0 && $prize ['count'] = 0;
		}
	
		// 		dump ( $prize );
		$this->assign ( 'prize', $prize );
	}
	
	// 抽奖或者优惠券领取的插件条件判断
	protected  function addon_condition_check($addon_condition) {
		preg_match_all ( "/\[([\s\S]*):([\*,\d]*)\]/i", $addon_condition, $match );
		if (empty ( $match [1] [0] ) || empty ( $match [2] [0] )) {
			return true;
		}
		$conditon ['token'] = TOKEN;
		$conditon ['uid'] = $_SESSION['jbr_admin_id'];
	
		switch ($match [1] [0]) {
			case '投票' :
				$match [2] [0] != '*' && $match [2] [0] > 0 && $conditon ['vote_id'] = $match [2] [0];
				$conditon ['user_id'] = $_SESSION['jbr_admin_id'];
				unset ( $conditon ['uid'] );
				$res = M ( 'vote_log' )->where ( $conditon )->find ();
				break;
			case '通用表单' :
				$match [2] [0] != '*' && $match [2] [0] > 0 && $conditon ['forms_id'] = $match [2] [0];
				$res = M ( 'forms_value' )->where ( $conditon )->find ();
				break;
			case '微考试' :
				$match [2] [0] != '*' && $match [2] [0] > 0 && $conditon ['exam_id'] = $match [2] [0];
				$res = M ( 'exam_answer' )->where ( $conditon )->find ();
				break;
			case '微测试' :
				$match [2] [0] != '*' && $match [2] [0] > 0 && $conditon ['test_id'] = $match [2] [0];
				$res = M ( 'test_answer' )->where ( $conditon )->find ();
				break;
			case '微调研' :
				$match [2] [0] != '*' && $match [2] [0] > 0 && $conditon ['survey_id'] = $match [2] [0];
				$res = M ( 'survey_answer' )->where ( $conditon )->find ();
				break;
			default :
				$match [2] [0] != '*' && $match [2] [0] > 0 && $conditon ['id'] = $match [2] [0];
				$res = M ( $match [1] [0] )->where ( $conditon )->find ();
		}
		// dump ( $res );
		// dump ( M ()->getLastSql () );
	
		return ! empty ( $res );
	}
	
function set_sn_code() {
		$data ['sn'] = uniqid ();
		$data ['uid'] = session('jbr_admin_id');
		$data ['cTime'] = time ();
		$data ['addon'] = 'Scratch';
		$data ['target_id'] = I ( 'id' );
		
		$data ['prize_id'] = $map ['id'] = I ( 'prize_id' );
		
		$title = '';
		if (! empty ( $map ['id'] )) {
			$title = M ( 'wp_prize' )->where ( $map )->getField ( 'title' );
			$title || $title = '';
		}
		$data ['prize_title'] = $title;
		//dump ( $data );
		
		$res = M( 'wp_sn_code')->add( $data );
		
		if ($res) {
			// 扣除积分
			/*
			$data = M ( 'scratch' )->find ( $data ['target_id'] );
			if (! empty ( $data ['credit_bug'] )) {
				$credit ['score'] = $data ['credit_bug'];
				$credit ['experience'] = 0;
				add_credit ( 'scratch_credit_bug', 5, $credit );
			}
			*/
		}
		echo $res;
	}
	
}