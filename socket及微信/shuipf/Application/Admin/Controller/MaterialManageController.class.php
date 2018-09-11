<?php
/* 
 * Created by NetBeans
 * User: Wangkg
 * Date: 2017-4-7
 * Time: 10:07:24
 */
namespace Admin\Controller;

use Common\Controller\ShuipFCMS;

class MaterialManageController extends ShuipFCMS{
	public function _initialize(){
		$appid['appid'] = 'wx21740294dcfe80af';
        $appid['secret'] = '4bc4d31728432c41772f291118e167d3';
		$this->appid = 'wx21740294dcfe80af';
		$this->secret = '4bc4d31728432c41772f291118e167d3';
        $datas = json_decode($this->get_php_file("./d/access_token.php"));
		
        if ($datas->expire_time < time()) {
                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid['appid'].'&secret='.$appid['secret'];
                $arr = json_decode(request_get($url),true);
                $this->access_token = $arr['access_token'];
            if ($arr['access_token']) {
                $datas->expire_time = time() + 7000;
                $datas->access_token = $arr['access_token'];
                $this->set_php_file("./d/access_token.php", json_encode($datas));
                }
        } else {
                $this->access_token  = $datas->access_token;
        }
	}
	
	public function imgList(){
		$model = M('weixin_img_url');
		//$where['type'] = ['in','img,thumb'];
		$count = $model->where($where)->count();
        $page = $this->page($count, 20);
        $data = $model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
		$this->assign('data',$data);
		$this->assign('TypeArr',array("img"=>"图片类型","thumb"=>"缩略图类型"));
		$this->assign('page',$page->show());
		$this->display();
	}
	
	public function uploadImg(){
		if(IS_POST){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg','jpeg','png','gif','mp3','wma','wav','amr','mp4');// 设置附件上传类型
			$fileName = rand(1111, 9999) . time();
			$upload->saveName = md5($fileName);
			$upload->autoSub = false;
		   // $path = $this->_getFilePath($upload->saveName);
			$upload->rootPath = './d/uploadFile/';
			$upload->savePath  =     ''; // 设置附件上传（子）目录
		   /* if(!$model->validate($model->getvalida())->create()){
						$this->success($model->getError(),__ROOT__."/Index/index",3);
						exit();
					}*/
			// 上传文件 
			$info   =   $upload->upload();//p($info);die;
			if(!$info) {// 上传错误提示错误信息
				echo json_encode(array('isError'=>true),JSON_UNESCAPED_UNICODE);
			}else{// 上传成功
				echo json_encode(array('isError'=>false,'uploadInfo'=>$info),JSON_UNESCAPED_UNICODE);
			}
		}else{
			$this->display();
		}
		
	}
	
	
	
	
	public function addImg(){
		$data = I('post.');
		
		switch ($data['uploadtype']){
			case 'image':
			$type='image';
			break;
		case 'thumb':
			$type='thumb';
			break;
		case 'voice':
			$type='voice';
			break;
		case 'video':
			$type='video';
			$des = array(
				'title'=>trim($data['title']),
				'introduction'=>trim($data['description']),
			);
			break;
		}
			
		//$url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->access_token.'&type='.$type;
		$url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.$this->access_token;
		
		if($data['uploadtype']=='thumb'){
			$url='http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->access_token.'&type=thumb';/******上传缩略图获取thumb_media_id******/
		}
		
		$file_info=array(
			'filename'=>$data['filepath'],  //图片相对于网站根目录的路径
			'content-type'=>$data['type'],  //文件类型
			'filelength'=>$data['size'],    //图文大小
		);

		$ch1 = curl_init();
		$timeout = 5;
		$real_path = './d/uploadFile/'.$data['filepath'];
		if($data['uploadtype']=='video'){
			$postdata= array("media"=>'@'.$real_path,'form-data'=>$file_info,'description'=>json_encode($des));
		}else{
			$postdata= array("media"=>'@'.$real_path,'form-data'=>$file_info);
		}
		
		curl_setopt ( $ch1, CURLOPT_URL, $url );
		curl_setopt ( $ch1, CURLOPT_POST, 1 );
		curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $ch1, CURLOPT_POSTFIELDS, $postdata );
		$result = curl_exec ( $ch1 );
		
		//$result = $this->request_post($url,$postdata);
		
		//var_dump($result);die;
		curl_close ( $ch1 );
		if(curl_errno()==0){
			$result1 = json_decode(stripslashes($result),true);
			
			if($data['uploadtype']=='image'){
				M('weixin_img_url')->add(array('title'=>trim($data['title']),'type'=>'image','url'=>$result1['url'],'created'=>time()));
			}else if($data['uploadtype']=='thumb'){
				M('weixin_img_url')->add(array('title'=>trim($data['title']),'type'=>'thumb','media_id'=>$result1['thumb_media_id'],'url'=>'./d/uploadFile/'.$data['filepath'],'created'=>$result1['created_at']));
			}else{
				M('weixin_img_url')->add(array('title'=>trim($data['title']),'type'=>$type,'media_id'=>$result1['media_id'],'url'=>'./d/uploadFile/'.$data['filepath'],'created'=>time()));
			}
			$this->success($result);
		}else {
			$this->error($result);
		}
	}
	
	
	
	public function newsList(){
		$model = M('weixin_news_list');
		//$where['type'] = ['in','img,thumb'];
		$count = $model->where($where)->count();
        $page = $this->page($count, 20);
        $data = $model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
		$this->assign('data',$data);
		$this->assign('TypeArr',array("news"=>"图文消息","thumb"=>"缩略图类型"));
		$this->assign('page',$page->show());
		$userlist = M('weixin_user_group')->select();
		$this->assign('userlist',json_encode($userlist));
		$this->display();
	}
	
	
	public function addnews(){
		$model = M('article');
		$count = $model->query('select count(*) as num from jbr_article as ja left join jbr_article_data as jad on ja.id=jad.id where ja.isweixin=1 order by ja.id asc');
        $page = $this->page($count[0]['num'], 30);
        $data = $model->alias('ja')->join('jbr_article_data as jad on ja.id=jad.id','left')->where('ja.isweixin=1')->limit($page->firstRow . ',' . $page->listRows)->order("ja.id asc")->select();
		$this->assign('data',$data);
		$this->assign('page',$page->show());
		$thumblist = M('weixin_img_url')->where("type='thumb'")->select();
		$this->assign('thumblist',json_encode($thumblist));
		$this->display();
	}
	
	/******上传图文消息获取media_id******/
	public function uploadNews(){
		if(IS_POST){
			$articleId = trim(I('post.articleId'),',');
			$url = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token='.$this->access_token;
			$articleArr = [];
			$sql = "select * from jbr_article as ja left join jbr_article_data as jad on ja.id=jad.id left join jbr_weixin_article as jwa on ja.id=jwa.article_id where jwa.article_id in ($articleId) order by jwa.show_cover_pic desc";
			$data = M()->query($sql);
			foreach($data as $k=>$v){
				$article[]=[
					"thumb_media_id"=>$v['thumb_media_id'],
					"author"=>$v['username'],
					"title"=>$v['title'],
					"content_source_url"=>$v['content_source_url'],
					"content"=>$v['content'],
					"digest"=>$v['description'],
					"show_cover_pic"=>$v['show_cover_pic'],
				];
			}
			

			$postData = [
				'articles'=>$article
			];
			
			$result = $this->request_post($url, json_encode($postData,JSON_UNESCAPED_UNICODE));
			if($result['media_id']){
				$result = json_decode($result,true);
				$result1 = M('weixin_news_list')->add(array('type'=>$result['type'],'media_id'=>$result['media_id'],'created'=>$result['created_at']));
				if($result1>0){
					echo json_encode(array('msg'=>'上传图文消息成功'));
				}else{
					echo json_encode(array('msg'=>'上传图文消息失败'));
				}
			}else{
				echo json_encode(array('msg'=>$result));
			}
			
		}
	}
	/****添加本地微信消息*****/
	public function addWxMsg(){
		if(IS_POST){
			$data = I('post.');
			$article = array(
				'thumb_media_id'=>$data['thumb_media_id'],
				'thumb_media_name'=>$data['thumb_media_name'],
				'show_cover_pic'=>$data['show_cover_pic'],
				'article_id'=>$data['article_id'],
				'title'=>$data['title'],
				'content_source_url'=>$data['content_source_url'],
				'created'=>date('Y-m-d H:i:s',time()),
			);
			if(M('weixin_article')->add($data)){
				echo json_encode(array('msg'=>'添加成功'));
			}else{
				echo json_encode(array('msg'=>'添加失败'));
			}
		}
	}
	
	/***预览消息接口***/
	public function previewMsg(){
		if(IS_POST){
			$media_id = I('get.media_id');
			if(M('weixin_news_list')->where("media_id='$media_id'")->find()){
				$openid = 'o8jJvt_lRmRQo2qP5OZBlQ9aSCMo';
				$url = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token='.$this->access_token;
				$data = [
					'touser'=>$openid,
					'mpnews'=>[
						  "media_id"=>$media_id
					],
					'msgtype'=>'mpnews'
				];
				$result = json_decode($this->request_post($url, json_encode($data,JSON_UNESCAPED_UNICODE)),true);
				if($result['errcode']==0){
					$this->success('预览消息已发送到手机，请注意查收');
				}
			}else{
				$this->success('要推送的信息不存在');
			}
		}
	}
	
	/***根据openID群发消息接口***/
	public function sendWxMsg(){
		if(IS_POST){
			$url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->access_token;
			$groupids = trim(I('post.groupids'),',');
			$media_id = I('post.media_id');
			$articleList = array();
			if($groupids!=''){
				$sql="select openid from jbr_weixin_userlist where groupid in ($groupids)";
			}else{
				$sql="select openid from jbr_weixin_userlist";
			}
			$users = M()->query($sql);
			//$openids = array_column($users,'openid');
			foreach($users as $k=>$v){
				$openids[]=$v['openid'];
			}
			$data = [
				'touser'=>$openids,
				'mpnews'=>[
						'media_id'=>$media_id
					],
				'msgtype'=>'mpnews',
				'send_ignore_reprint'=>0
			];
			
			//var_dump(json_encode($data));die;
			$result = json_decode($this->request_post($url, json_encode($data,JSON_UNESCAPED_UNICODE)),true);
			echo json_encode($result);
		}
		
		
		
	}
	/*****待生成消息列表******/
	public function wxArticleList(){
		$model = M('weixin_article');
		//$list = M()->query('select *,wh.id as ids from jbr_weixin_huifu as wh left join jbr_article as ja on wh.id = ja.id left join jbr_article_data as jad on wh.id=ja.id where wh.leixin=2 group by ids');
		$count = $model->query('select count(*) as num from jbr_weixin_article order by id desc');
        $page = $this->page($count[0]['num'], 20);
        $data = $model->limit($page->firstRow . ',' . $page->listRows)->order("id DESC")->select();
		$this->assign('data',$data);
		$this->assign('typeArr',array(0=>'否',1=>'是'));
		$this->assign('page',$page->show());
		$this->display();
	}
	
	function request_post($url,$data) {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
           echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }

	function request_get($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		$res = curl_exec($curl);
		curl_close($curl);
		return $res;
	}
	
	
	private function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}