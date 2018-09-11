<?php
namespace Admin\Controller;

use Common\Controller\ShuipFCMS;

class ChatController extends ShuipFCMS{
	public function index(){
		$this->display();
		//Vendor('Chat.Web.index');
	}
	
	public function ajaxSetUser(){
		/*
		$uid = I('post.uid');
		$userlist = $_SESSION['userlist']?$_SESSION['userlist']:array();
		array_push($userlist,$uid);
		$_SESSION['userlist'] = $userlist;
		//$_SESSION['userlist']=null;
		//var_dump($_SESSION['userlist']);
		echo json_encode($_SESSION['userlist']);*/
		
	}
	
	public function ajaxGetUser(){
		//$_SESSION['userlist']=null;
		session_start();
		echo '<pre>';
		print_r($_SESSION);
	}
	
	public function send(){
		$to_uid = I('post.uid');
		$content = I('post.content');
		// 推送的url地址，使用自己的服务器地址
		$push_api_url = "192.168.2.168:2121";
		$post_data = array(
		   "type" => "publish",
		   "content" => $content,
		   "to" => $to_uid, 
		);
		$msgData = array(
			'uid'=>'admin',
			'fid'=>$to_uid,
			'content'=>$content,
			'time'=>date('Y-m-d H:i:s',time()),
		);
		M('web_chat')->add($msgData);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		var_export($return);
	}
}