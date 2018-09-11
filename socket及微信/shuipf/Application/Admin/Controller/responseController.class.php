<?php
// +----------------------------------------------------------------------
// | 微信回复配置
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 All rights reserved.
// +----------------------------------------------------------------------
// | Author: 赵杰
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\ShuipFCMS;

class responseController extends ShuipFCMS 
{
	//文字回复Xml
	public $textXml="<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
	//图文回复
	public $imgXml="<xml>
					 <ToUserName><![CDATA[%s]]></ToUserName>
					 <FromUserName><![CDATA[%s]]></FromUserName>
					 <CreateTime>%s</CreateTime>
					 <MsgType><![CDATA[%s]]></MsgType>
					 <ArticleCount>1</ArticleCount>
					 <Articles>
					 <item>
					 <Title><![CDATA[%s]]></Title> 
					 <Description><![CDATA[%s]]></Description>
					 <PicUrl><![CDATA[%s]]></PicUrl>
					 <Url><![CDATA[%s]]></Url>
					 </item>
					 </Articles>
					 <FuncFlag>1</FuncFlag>
					 </xml>";
		//图文回复
	public $imgXml_all="<xml>
					 <ToUserName><![CDATA[%s]]></ToUserName>
					 <FromUserName><![CDATA[%s]]></FromUserName>
					 <CreateTime>%s</CreateTime>
					 <MsgType><![CDATA[%s]]></MsgType>
					 <ArticleCount>1</ArticleCount>
					 <Articles>
					 <item>
					 <Title><![CDATA[%s]]></Title> 
					 <Description><![CDATA[%s]]></Description>
					 <PicUrl><![CDATA[%s]]></PicUrl>
					 <Url><![CDATA[%s]]></Url>
					 </item>
					 <item>
					 <Title><![CDATA[%s]]></Title> 
					 <Description><![CDATA[%s]]></Description>
					 <PicUrl><![CDATA[%s]]></PicUrl>
					 <Url><![CDATA[%s]]></Url>
					 </item>
					 <item>
					 <Title><![CDATA[%s]]></Title> 
					 <Description><![CDATA[%s]]></Description>
					 <PicUrl><![CDATA[%s]]></PicUrl>
					 <Url><![CDATA[%s]]></Url>
					 </item>
					 </Articles>
					 <FuncFlag>1</FuncFlag>
					 </xml>";	
	
	public function responseMsg($postStr)
	{
		if (!empty ($postStr)) {
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
            $msgType=$postObj->MsgType;
			$EventKey = trim($postObj->EventKey);
			$Event = trim($postObj->Event);
			$time = time();
			//关注自动回复开始
			if($Event=="subscribe")
			{
				$this->getConcern();
			}
			//关注自动回复结束
			
			//文本回复
			if($Event == 'Content')
			{
				$tmp = M('wp_keyword');
				$where="and keyword like '{$EventKey}'";
				$info = $tmp->where("token='{$signature}' {$where}")->find();
				if($info['addon'] == "jbr_wp_custom_reply_text")
				{
				//	纯文本回复
					return $this->getTextreg($info);
				}
				elseif($info['addon'] == "jbr_wp_custom_reply_news")
				{
				//	图文回复
					return $this->getTextimgreg($info);
				}
				else
				{
				//	多图文回复
					return $this->getTextmultreg($info);
				}
			}
		} else {
			return "";
		}
	}
	
	//获取关注时回复的数据
	public function getConcern()
	{
		//推送到微信的XML数据格式
		$tmp = M('wp_member_public');
		$content = $tmp->where("token='{$signature}'")->find();
		$tmps = json_decode($content['addon_config'],true);
		if(empty($tmps['Wecome']['img_url']))
		{
			$msgType = "text";
			$contentStr = "{$tmps['Wecome']['title']}!<a href=\"{$tmps['Wecome']['url']}/openid/".$fromUsername."\">{$tmps['Wecome']['description']}</a>";
			$resultStr = sprintf($this->textXml, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		}else
		{
			$msgType = "news";
			$title1=$tmps['Wecome']['title'];
			$Description=$tmps['Wecome']['description'];
			$PicUrl="{$tmps['Wecome']['headface_url']}";
			$Url="{$tmps['Wecome']['url']}/openid/".$fromUsername;
			$resultStr = sprintf($this->imgXml, $fromUsername, $toUsername, $time, $msgType, $title1,$Description,$PicUrl,$Url);
		}
		return $resultStr;
	}

	//文本回复
	public function getTextreg($keyword)
	{
		$tmp = M($keyword['addon']);
		if($keyword['keyword_type'] == 0)
		{
			$content = $tmp->where("token='{$signature}' and title='{$keyword['keyword']}'")->find();
		}
		elseif($keyword['keyword_type'] == 1)
		{
			$content = $tmp->where("token='{$signature}' and title like '{$keyword['keyword']}%'")->find();
		}
		elseif($keyword['keyword_type'] == 2)
		{
			$content = $tmp->where("token='{$signature}' and title like '%{$keyword['keyword']}'")->find();
		}
		elseif($keyword['keyword_type'] == 3)
		{
			$content = $tmp->where("token='{$signature}' and title like '%{$keyword['keyword']}%'")->find();
		}
		$msgType = "text";
		$contentStr = "<a href=\"{$content['url']}/openid/".$fromUsername."\">{$content['title']}!</a><br />{$content['content']}";
		$resultStr = sprintf($this->textXml, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}
	
	//图文回复
	public function getTextimgreg($keyword)
	{	
		$tmp = M($keyword['addon']);
		if($keyword['keyword_type'] == 0)
		{
			$content = $tmp->where("token='{$signature}' and title='{$keyword['keyword']}'")->find();
		}
		elseif($keyword['keyword_type'] == 1)
		{
			$content = $tmp->where("token='{$signature}' and title like '{$keyword['keyword']}%'")->find();
		}
		elseif($keyword['keyword_type'] == 2)
		{
			$content = $tmp->where("token='{$signature}' and title like '%{$keyword['keyword']}'")->find();
		}
		elseif($keyword['keyword_type'] == 3)
		{
			$content = $tmp->where("token='{$signature}' and title like '%{$keyword['keyword']}%'")->find();
		}
		$msgType = "news";
		$title1=$tmps['Wecome']['title'];
		$Description=$tmps['Wecome']['description'];
		$PicUrl="{$tmps['Wecome']['headface_url']}";
		$Url="{$tmps['Wecome']['url']}/openid/".$fromUsername;
		$resultStr = sprintf($this->imgXml, $fromUsername, $toUsername, $time,$msgType, $title1,$Description,$PicUrl,$Url);
		return $resultStr;
	}
	protected function getMoreMsg($ids){
		$where['id'] = array('in',$ids);
		$content = D('jbr_wp_custom_reply_news')->where($where)->select();
		$count = count($content);
		
		$msgType = "news";
		$title1=$content['title'];
		$Description=$content['description'];
		$PicUrl="{$content['headface_url']}";
		$resultStr ="<xml>
					<ToUserName><![CDATA[{$fromUsername}]]></ToUserName>
					<FromUserName><![CDATA[{$toUsername}]]></FromUserName>
					<CreateTime>{$time}</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<ArticleCount>{$count}</ArticleCount>
					<Articles>";
		foreach($content as $key=>$value){
			$Url="{$content['url']}/openid/".$fromUsername;
			$resultStr .= "<item>
			<Title><![CDATA[{$value['title']}]]></Title>
			<Description><![CDATA[{$value['intro']}]]></Description>
			<PicUrl><![CDATA[{$value['cover']}]]></PicUrl>
			<Url><![CDATA[{$Url}]]></Url>
			</item>";
		}	
		$resultStr .= "</Articles></xml>";	
		return $resultStr;
	}
	
	//多图文
	public function getTextmultreg($keyword)
	{
		$tmp = M($keyword['addon']);
		if($keyword['keyword_type'] == 0)
		{
			$content = $tmp->where("token='{$signature}' and title='{$keyword['keyword']}'")->find();
			$resultStr = $this->getMoreMsg($content['mult_ids']);
		}
		elseif($keyword['keyword_type'] == 1)
		{
			$content = $tmp->where("token='{$signature}' and title like '{$keyword['keyword']}%'")->find();
		}
		elseif($keyword['keyword_type'] == 2)
		{
			$content = $tmp->where("token='{$signature}' and title like '%{$keyword['keyword']}'")->find();
		}
		elseif($keyword['keyword_type'] == 3)
		{
			$content = $tmp->where("token='{$signature}' and title like '%{$keyword['keyword']}%'")->find();
		}
		//$msgType = "news";
		//$title1=$content['title'];
		//$Description=$content['description'];
		//$PicUrl="{$content['headface_url']}";
		//$Url="{$content['url']}/openid/".$fromUsername;
		//$resultStr = sprintf($this->imgXml_all, $fromUsername, $toUsername, $time,$msgType, $title1,$Description,$PicUrl,$Url);
		return $resultStr;
	}
}
