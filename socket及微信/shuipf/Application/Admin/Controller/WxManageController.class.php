<?php
/* 
 * Created by NetBeans
 * User: Wangkg
 * Date: 2017-4-7
 * Time: 10:07:24
 */
namespace Admin\Controller;

use Common\Controller\ShuipFCMS;

class WxManageController extends ShuipFCMS{
    
    public function _initialize(){
        //$appid=M('weixin_appid')->where('deleted=0')->find();
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
        if(htmlspecialchars(addslashes($_GET["echostr"]),ENT_QUOTES)){
            $echoStr = htmlspecialchars(addslashes($_GET["echostr"]),ENT_QUOTES);
            $signature = htmlspecialchars(addslashes($_GET["signature"]),ENT_QUOTES);
            $timestamp = htmlspecialchars(addslashes($_GET["timestamp"]),ENT_QUOTES);
            $nonce = htmlspecialchars(addslashes($_GET["nonce"]),ENT_QUOTES);					
            $token = 'weixin';
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );
            //valid signature , option
            if($tmpStr == $signature){
                echo $echoStr;
                exit;
            }
        }
		
    }
    
    
    public function index(){
        define("TOKEN", "weixin");
        if (!isset($_GET['echostr'])) {
            $this->responseMsg();
        }else{
            $this->valid();
        }
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            echo $echoStr;
            exit;
        }
    }
    
     public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R \r\n".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            
            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    //$this->ajaxSend($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    case "shortvideo":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T \r\n".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }
    

            
    function getUserInfoByOpenId($openId = 'o8jJvt_lRmRQo2qP5OZBlQ9aSCMo'){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$openId.'&lang=zh_CN';
        $result = request_get($url);
        return json_decode($result,true);
    }
    
    
    
    function getUserList(){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->access_token.'&next_openid=';
        $result = request_get($url);
        return json_decode($result,true);
    }
    
    

    
    public function arrayToXml($arr){ 
        $xml = ""; 
        foreach ($arr as $key=>$val){ 
            if(is_array($val)){ 
                $xml.="<".$key.">".$this->arrayToXml($val)."</".$key.">"; 
            }else{ 
                $xml.="<".$key.">".$val."</".$key.">"; 
            } 
        } 
        $xml.=""; 
        return $xml;
    }

    //接收事件消息
    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                $content = "欢迎关注！请回复以下关键字：文本 表情 单图文 多图文 音乐\n请按住说话 或 点击 + 再分别发送以下内容：语音 图片 小视频 我的收藏 位置";
                $content .= (!empty($object->EventKey))?("\n来自二维码场景 ".str_replace("qrscene_","",$object->EventKey)):"";
				$content .= "\n\n".'<a href="https://wangkaigui.applinzi.com/">Author 王开贵</a>';
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "COMPANY":
                        $content = array();
                        $content[] = array("Title"=>"Author 王开贵", "Description"=>"", "PicUrl"=>"https://wangkaigui.applinzi.com/", "Url" =>"https://wangkaigui.applinzi.com/");
                        break;
                    default:
                        $content = "点击菜单：".$object->EventKey.','.$object->FromUserName.','.$object->ToUserName;
                        break;
                }
                break;
            case "VIEW":
                $content = "跳转链接 ".$object->EventKey;
                break;
            case "SCAN":
                $content = "扫描场景 ".$object->EventKey;
                break;
            /*
            case "LOCATION":
                $content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;*/
            case "scancode_waitmsg":
                if ($object->ScanCodeInfo->ScanType == "qrcode"){
                    $content = "扫码带提示：类型 二维码 结果：".$object->ScanCodeInfo->ScanResult;
                }else if ($object->ScanCodeInfo->ScanType == "barcode"){
                    $codeinfo = explode(",",strval($object->ScanCodeInfo->ScanResult));
                    $codeValue = $codeinfo[1];
                    $content = "扫码带提示：类型 条形码 结果：".$codeValue;
                }else{
                    $content = "扫码带提示：类型 ".$object->ScanCodeInfo->ScanType." 结果：".$object->ScanCodeInfo->ScanResult;
                }
                break;
            case "scancode_push":
                $content = "扫码推事件";
                break;
            case "pic_sysphoto":
                $content = "系统拍照";
                break;
            case "pic_weixin":
                $content = "相册发图：数量 ".$object->SendPicsInfo->Count;
                break;
            case "pic_photo_or_album":
                $content = "拍照或者相册：数量 ".$object->SendPicsInfo->Count;
                break;
            case "location_select":
                $content = "发送位置：标签 ".$object->SendLocationInfo->Label;
                break;
            /*
            default:
                $content = "receive a new event: ".$object->Event;
                break;*/
        }

        if(is_array($content)){
            $result = $this->transmitNews($object, $content);
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        //多客服人工回复模式
        if (strstr($keyword, "请问在吗") || strstr($keyword, "在线客服")){
            $result = $this->transmitService($object);
            return $result;
        }
        
        $list = M('weixin_huifu')->select();
        foreach ($list as $k=>$v){
			if($v['leixin']==1){
				if (strstr($keyword, $v['key'])){
					$content = $v['text'];
				}
			}else if($v['leixin']==2){
				if (strstr($keyword, "单图文")){
					$content = array();
					$content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://www.aturing.top/themes/simplebootx/Public/assets/images/logo.png", "Url" =>"http://www.aturing.top");
				}
			}
			
			
			
            /*else{
                $content = date("Y-m-d H:i:s",time())."\n\n".'<a href="https://wangkaigui.applinzi.com/">默认模式 Author 王开贵</a>';
            }*/
        }
        $result = $this->transmitText($object, $content);
        /*
        //自动回复模式
        if (strstr($keyword, "文本")){
            $content = "这是个文本消息";
        }else if (strstr($keyword, "表情")){
            $content = "微笑：/::)\n乒乓：/:oo\n中国：".$this->bytes_to_emoji(0x1F1E8).$this->bytes_to_emoji(0x1F1F3)."\n仙人掌：".$this->bytes_to_emoji(0x1F335);
        }else if (strstr($keyword, "单图文")){
            $content = array();
            $content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
            $content = array();
            $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "音乐")){
            $content = array();
            $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://mascot-music.stor.sinaapp.com/zxmzf.mp3", "HQMusicUrl"=>"http://mascot-music.stor.sinaapp.com/zxmzf.mp3"); 
        }else{
            $content = date("Y-m-d H:i:s",time())."\n\n".'<a href="https://wangkaigui.applinzi.com/">Author 王开贵</a>';
        }
		*/
        if(is_array($content)){
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收图片消息
    private function receiveImage($object)
    {
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = "你刚才说的是：".$object->Recognition;
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }
        return $result;
    }

    //接收视频消息
    private function receiveVideo($object)
    {
        $content = "上传视频类型：".$object->MsgType;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)){
            return "";
        }

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return "";
        }
        $itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        if(!is_array($musicArray)){
            return "";
        }
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
    </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复第三方接口消息
    private function relayPart3($url, $rawData)
    {
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //字节转Emoji表情
    function bytes_to_emoji($cp)
    {
        if ($cp > 0x10000){       # 4 bytes
            return chr(0xF0 | (($cp & 0x1C0000) >> 18)).chr(0x80 | (($cp & 0x3F000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x800){   # 3 bytes
            return chr(0xE0 | (($cp & 0xF000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x80){    # 2 bytes
            return chr(0xC0 | (($cp & 0x7C0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else{                    # 1 byte
            return chr($cp);
        }
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 1000000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
    
    
    /*
    public function responseMsg(){		
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];	
        if (!empty($postStr)){                
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = trim($postObj->FromUserName);
        $toUsername = trim($postObj->ToUserName);
        $keyword = trim($postObj->Content);
        $image = trim($postObj->PicUrl);
        $Location_X = trim($postObj->Location_X);
        $Location_Y = trim($postObj->Location_Y);
        $Scale = trim($postObj->Scale);
        $Label = trim($postObj->Label);
        $Title = trim($postObj->Title);
        $Description = trim($postObj->Description);
        $Url = trim($postObj->Url);
        if( trim($postObj->Content)){				
            $Msgtype = "text";				
        }
        if(trim($postObj->PicUrl)){						
            $Msgtype = "image";						
        }
        if(trim($postObj->Recognition)){						
            $Msgtype = "voice";
        }
        if(trim($postObj->ThumbMediaId)){						
            $Msgtype = "video";
        }
        if(trim($postObj->Label)){						
            $Msgtype = "location";						
        }
        if(trim($postObj->Url)){						
            $Msgtype = "link";						
        }					
            $time = trim($postObj->CreateTime);
            $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
				
        //事件推送------
        $ev = trim($postObj->Event);	
                //关注事件
        if($ev == "subscribe")
        {	
            $event=M('weixin_gz')->where("leixin=1")->find();
            if($event){
                $msgType = "text";
                $contentStr = $event['text'];
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{	
                $huifu=M('weixin_gz')->where("leixin=2")->find();					
                $cate=M('cate')->find($huifu['cid']);
                $cids=M('cate')->where("pid=$cate[id]")->getField('id',true);
                if($cids){
                $allid=implode(',',$cids).','.$cate['id'];
                }else{
                        $allid=$cate['id'];
                }
                $piclist=M('info')->where("cid IN ($allid)")->where("isshow=1")->order($huifu['sort'])->limit($huifu['num'])->select();

                $newsxml = "<xml><ToUserName><![CDATA[".$fromUsername."]]></ToUserName><FromUserName><![CDATA[".$toUsername."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>".$huifu['num']."</ArticleCount><Articles>%s</Articles></xml>";
                $itemxml = "";
                foreach ($piclist as $key => $value) {
                    $itemxml .= "<item>";
                    $itemxml .= "<Title><![CDATA[".$value['name']."]]></Title><Description><![CDATA[".$value['desc']."]]></Description><PicUrl><![CDATA[".C('domain').$value['pic']."]]></PicUrl><Url><![CDATA[".C('domain').U('/'.$value['id'])."]]></Url>";
                    $itemxml .= "</item>";
                }
                $resultStr = sprintf($newsxml, $itemxml);
                echo $resultStr;					
            }
				
	}	
	//菜单点击回复
			
        $menumsgtype = trim($postObj->MsgType);
        $EventKey = trim($postObj->EventKey);
        if($ev=='CLICK'){
        $key=M('weixin_huifu')->where(array('key'=>$EventKey,'leixin'=>'1'))->find();
        $tu=M('weixin_huifu')->where(array('key'=>$EventKey,'leixin'=>'2'))->find();						
        $cate=M('cate')->find($tu['cid']);
            $cids=M('cate')->where("pid=$cate[id]")->getField('id',true);
            if($cids){
            $allid=implode(',',$cids).','.$cate['id'];
            }else{
                    $allid=$cate['id'];
            }
        $piclist=M('info')->where("cid IN ($allid)")->where("isshow=1")->order($tu['sort'])->limit($tu['num'])->select();	

        if($key){							
                $msgType = "text";
                $contentStr = $key['text'];
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
        }elseif($tu){								
                $newsxml = "<xml><ToUserName><![CDATA[".$fromUsername."]]></ToUserName><FromUserName><![CDATA[".$toUsername."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>".$tu['num']."</ArticleCount><Articles>%s</Articles></xml>";
                $itemxml = "";
                foreach ($piclist as $key => $value) {
                    $itemxml .= "<item>";
                    $itemxml .= "<Title><![CDATA[{$value['name']}]]></Title><Description><![CDATA[{$value['desc']}]]></Description><PicUrl><![CDATA[".C('domain')."{$value['pic']}]]></PicUrl><Url><![CDATA[".C('domain').U('/'.$value['id'])."]]></Url>";
                    $itemxml .= "</item>";
                }
                $resultStr = sprintf($newsxml, $itemxml);
                echo $resultStr;							
        }

}
    if($keyword){	
        $huifu=M('weixin_huifu')->where(array('key'=>$keyword))->find();						
        if($huifu['leixin']=='1'){
            $msgType = "text";
            $contentStr = $huifu['text'];
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }elseif($huifu['leixin']=='2'){
                $cate=M('cate')->find($huifu['cid']);
                $cids=M('cate')->where("pid=$cate[id]")->getField('id',true);
                if($cids){
                    $allid=implode(',',$cids).','.$cate['id'];
                }else{
                        $allid=$cate['id'];
                }
                $piclist=M('info')->where("cid IN ($allid)")->where("isshow=1")->order($huifu['sort'])->limit($huifu['num'])->select();								
                $newsxml = "<xml><ToUserName><![CDATA[".$fromUsername."]]></ToUserName><FromUserName><![CDATA[".$toUsername."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>".$huifu['num']."</ArticleCount><Articles>%s</Articles></xml>";
                $itemxml = "";
                foreach ($piclist as $key => $value) {
                        $itemxml .= "<item>";
                        $itemxml .= "<Title><![CDATA[".$value['name']."]]></Title><Description><![CDATA[".$value['desc']."]]></Description><PicUrl><![CDATA[".C('domain').$value['pic']."]]></PicUrl><Url><![CDATA[".C('domain').U('/'.$value['id'])."]]></Url>";
                        $itemxml .= "</item>";
                }
                $resultStr = sprintf($newsxml, $itemxml);
                echo $resultStr;							
                    }
            }else{	
                $msgType = "text";
                $contentStr = C('webdesc');
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }			
        }

    }
     * 
     */
    
    public function ajaxSort(){
        $data = I('post.');
        $result = M('weixin_menu')->where("id = ".$data["id"])->setField(array('sort'=>$data['sorts']));
        if($result>0){
            $this->_ajaxSuccess();
        }else{
            $this->_ajaxFailure();
        }
    }
	
	public function reply(){
            $huifu=M('weixin_huifu')->select();
            foreach($huifu as $k=>$v){

                    $c=M('cate')->find($v['cid']);
                    $huifu[$k]['catename']=$c['catename'];
            }
            $this->huifu=$huifu;
            $this->cate=M('cate')->select();
            $this->assign('list',$huifu);
            $this->display();
	}
	
	public function addmenu(){
		if(IS_POST){
            if(I('post.pid')==0){
            $con=count(M('weixin_menu')->where('pid=0 and deleted=0')->select());
            if($con==3){
                $this->error('最多只能添加3个主菜单');
            }
        }		
            if(M('weixin_menu')->add(I('post.'))){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{		
            $this->appid=M('weixin_appid')->find();	
            $this->menu=M('weixin_menu')->where('pid=0 and deleted=0')->select();
            $menulist=M('weixin_menu')->where('pid=0 and deleted=0')->order('sort ASC')->select();
            foreach($menulist as $k=>$v){
                $er=M('weixin_menu')->where(array('pid'=>$v['id']))->order('sort ASC')->select();
                $menulist[$k]['sub']=$er;
            }
            $this->menulist=$menulist;
            $this->keys=M('weixin_huifu')->select();
			$this->assign('keys',$this->keys);
            $this->display();
        }
	}
	
	public function createMenu(){
		if(IS_POST){
            if(I('post.pid')==0){
            $con=count(M('weixin_menu')->where('pid=0 and deleted=0')->select());
            if($con==3){
                $this->error('最多只能添加3个主菜单');
            }
        }		
            if(M('weixin_menu')->add(I('post.'))){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{		
            $this->appid=M('weixin_appid')->find();	
            $this->menu=M('weixin_menu')->where('pid=0 and deleted=0')->select();
            $menulist=M('weixin_menu')->where('pid=0 and deleted=0')->order('sort ASC')->select();
            foreach($menulist as $k=>$v){
                $er=M('weixin_menu')->where(array('pid'=>$v['id']))->order('sort ASC')->select();
                $menulist[$k]['sub']=$er;
            }
            $this->menulist=$menulist;
            $this->keys=M('weixin_huifu')->select();
			$this->assign('keys',$this->keys);
            $this->display();
        }
	}
	
	public function menuList(){
		 
	}
	
	


	//服务号自定义菜单
    public function actionaddMenu(){
        $appid=M('weixin_appid')->where('deleted=0')->find();

        header("Expires:Mon,26Jul199705:00:00GMT");
        header("Pragma:no-cache");
        //设置编码
        header("Content-Type:text/html;charset=utf-8");
        //获取远程文件内容

        
       
        $post = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->access_token;
        $data = '{"button":[';
        $class = M('weixin_menu')->where(array('pid'=>0))->limit(3)->order('sort desc')->select();
        $i = 1;
        foreach($class as $key=>$vo){
            //main menu
            $data .= '{"name":"'.$vo['title'].'",';
            $c = M('weixin_menu')->where(array('pid'=>$vo['id']))->limit(5)->order('sort desc')->select();
            $count = M('weixin_menu')->where(array('pid'=>$vo['id']))->limit(5)->order('sort desc')->count();
            if($c != false){
                    $data .= '"sub_button":[';
            }else{
                if ($vo['leixin'] == "1") {
                        $data .= '"type":"click","key":"'.$vo['keys'].'"';
                } elseif($vo['leixin'] == "0") {
                        $data .= '"type":"view","url":"'.$vo['url'].'"';
                }
            }
            $i = 1;
            foreach($c as $voo){
                if($i == $count){
                    if ($voo['leixin'] == "1") {
                            $data .= '{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keys'].'"}';
                    } elseif($voo['leixin'] == "0") {
                            $data .= '{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"}';
                    }
                }else{
                    if ($voo['leixin'] == "1") {
                            $data .= '{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keys'].'"},';
                    } elseif($voo['leixin'] == "0") {
                            $data .= '{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"},';
                    }
                }
                $i++;
            }
            if($c!=false){
                    $data .= ']';
            }
            if($key < 2){
                    $data .= '},';
            }elseif($key == 2){
                    $data .= '}';
            }
    }
        $data .= ']}';
        $menuback = json_decode($this->request_post($post,$data),true);
        //writeLog("更新微信自定义菜单appid: ".$appid['appid']." secret: ".$appid['secret']);
        $this->success('[返回编号：'.$menuback['errcode'].']'.'返回代码：['.$menuback['errmsg'].']');
				
	}
	
    public function actionSetConfig(){
        if(IS_POST){
            $wx_key   = I('post.wx_key');
            $wx_sec   = I('post.wx_sec');
            $data = array(
                'THINK_SDK_MPWEIXIN' => array(
                    'APP_KEY'    => $wx_key,
                    'APP_SECRET' => $wx_sec,
                ),
            );
            $result=sp_set_dynamic_config($data);
            M('weixin_appid')->where('1')->delete();
            $info = array('appid'=>$wx_key,'secret'=>$wx_sec);
            $sResult = M('weixin_appid')->add($info);
           
            if($result && $sResult!==false){
                writeLog("更新微信app_key和app_secret");
                $this->success("更新成功！");
            }else{
                $this->error("更新失败！");
            }
        }
    }
	
	public function setConfig(){
		$model = M('weixin_appid');
		if(IS_POST){
			$data = I('post.');
			$configdata = array(
				'appid'=>trim($data['appid']),
				'secret'=>trim($data['secret']),
			);
			//var_dump($configdata);
			if($model->where('deleted=0')->save($configdata)!==false){
				$this->success('更新成功！');
			}else{
				$this->error('更新失败！');
			}
		}else{
			$config = $model->find();
			$this->assign('info',$config);
			$this->display();
		}
		
	}
   
    public function imagetexts(){
		$model = M('article');
		//$list = M()->query('select *,wh.id as ids from jbr_weixin_huifu as wh left join jbr_article as ja on wh.id = ja.id left join jbr_article_data as jad on wh.id=ja.id where wh.leixin=2 group by ids');
		$count = $model->query('select count(*) as num from jbr_article as ja left join jbr_article_data as jad on ja.id=jad.id order by ja.id asc');
        $page = $this->page($count[0]['num'], 30);
        $data = $model->alias('ja')->join('jbr_article_data as jad on ja.id=jad.id','left')->limit($page->firstRow . ',' . $page->listRows)->order("ja.id asc")->select();
		$this->assign('data',$data);
		$this->assign('page',$page->show());
		$userlist = M('weixin_user_group')->select();
		$this->assign('userlist',json_encode($userlist));
		$this->display();
	}
	/***发送图文消息（客服）***/
	public function pushImgMsg(){
		//$content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://www.aturing.top/themes/simplebootx/Public/assets/images/logo.png", "Url" =>"http://www.aturing.top");
		$info = I('post.');
		$groupids = trim($info['groupids'],',');
		$articleId = trim($info['articleId'],',');
		$sucNum = 0;
		$errNum = 0;
		$articleList = array();
		if($groupids!=''){
			$sql="select openid from jbr_weixin_userlist where groupid in ($groupids)";
		}else{
			$sql="select openid from jbr_weixin_userlist";
		}
		$users = M()->query($sql);
		$article = M()->query("select * from jbr_article where id in ($articleId) limit 0,10");
		foreach($article as $kk=>$vv){
			$articleList[]= array(
				'title'=>$vv['title'],
				'description'=>mb_substr($vv['description'],0,8,'utf-8'),
				'url'=>'http://www.aturing.top/themes/simplebootx/Public/assets/images/logo.png',
				'picurl'=>'http://www.aturing.top/themes/simplebootx/Public/assets/images/logo.png',
			);
			
		}
		foreach($users as $k=>$v){
			$msg = array(
				'touser'=>$v['openid'],
				'msgtype'=>'news',
				'news'=>
					array('articles'=>$articleList),		
			);
			
			$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$this->access_token;
			//$this->ajaxAddMsg($msg,$openid);
			$result = json_decode($this->request_post($url, json_encode($msg,JSON_UNESCAPED_UNICODE)),true);

			if($result['errcode']==0 && $result['errmsg']=='ok'){
				$sucNum+=1;
			}else{
				$errNum+=1;
			}
		}
		echo json_encode(array('sucNum'=>$sucNum,'errNum'=>$errNum));
		
	}
	/****发送文本消息****/
	public function sendText(){
		 if(IS_POST){
            $msg = I('post.msg');
			if($msg==''){
				$this->error('发送内容不能为空');
			}
			$sucNum = 0;
			$errNum = 0;
            $groupid = I('post.groupid');
            $access_token = $this->access_token;
			if($groupid==''){
				$sql="select openid from jbr_weixin_userlist";
			}else{
				$sql="select openid from jbr_weixin_userlist where groupid in ($groupid)";
			}
			$users = M()->query($sql);
			foreach($users as $k=>$v){
				$data = array(
					'touser'=>$v['openid'],
					'msgtype'=>'text',
					'text'=>array(
						"content"=>$msg,
					),
				);
				$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
				$result = json_decode($this->request_post($url, json_encode($data,JSON_UNESCAPED_UNICODE)),true);
				if($result['errcode']==0 && $result['errmsg']=='ok'){
					$sucNum+=1;
				}else{
					$errNum+=1;
				}
			}
			$this->success('发送成功：'.$sucNum." 发送失败：".$errNum);
        }else{
			$grouplist = M()->query("select * from jbr_weixin_user_group");
			$this->assign('grouplist',$grouplist);
			$this->display();
		}
	}
	
	/**
     * @descrpition 图文 - 先调用self::newsItem()再调用本方法
     * @param $fromusername
     * @param $tousername
     * @param $item 数组，每个项由self::newsItem()返回
     * @param $funcFlag 默认为0，设为1时星标刚才收到的消息
     * @return string
     */
    //回复图文消息
    private function news($fromUsername,$toUsername, $newsArray)
    {
        if(!is_array($newsArray)){
            return "";
        }
        $itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";

        $result = sprintf($xmlTpl, $fromUsername, $toUsername, time(), count($newsArray));
        return $result;
    }
	
	public function grouplist(){
		$this->display();
	}
	
	public function addgroup(){
		if(IS_POST){
			$groupname = I('post.groupname');
			$openids = trim(I('post.openids'),',');
			$groupid = rand(100,999);
			$data = ['groupname'=>$groupname,'groupid'=>$groupid];
			M('weixin_user_group')->add($data);
			M()->query("update jbr_weixin_userlist set groupid=$groupid where openid in ($openids)");
			
		}else{
			$info = M('weixin_userlist')->alias('u')->join('join jbr_weixin_user_group as up on up.groupid=u.groupid','left')->select();
			$this->assign('data',$info);
			$this->assign('sexArr',array('0'=>'女','1'=>'男'));
			$this->display();
		}
		
	}
	
    public function userList(){
		$model = M('weixin_userlist');
		$count = $model->where($where)->count();
        $page = $this->page($count, 20);
        $data = $model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
		$this->assign('data',$data);
		$this->assign('page',$page->show());
		$this->assign('sexArr',array('0'=>'女','1'=>'男'));
        $this->display();
    }
    /***更新用户列表操作**/
    public function updateUser(){
        $userlist = M('weixin_userlist')->select();
        $openids = array_column($userlist,'openid');
        $list = $this->getUserList();
        $data = $list['data']['openid'];
        foreach ($data as $k=>$v){
            $userdata = $this->getUserInfoByOpenId($v);
			var_dump($userdata);die;
            unset($userdata['tagid_list']);
			unset($userdata['groupid']);
			unset($userdata['subscribe_scene']);
            if(!in_array($userdata['openid'],$openids)){
                M('weixin_userlist')->add($userdata);
            }
        }
		$this->success();
    }
   
   public function keywordList(){
	    $huifu=M('weixin_huifu')->select();
		foreach($huifu as $k=>$v){
			$c=M('cate')->find($v['cid']);
			$huifu[$k]['catename']=$c['catename'];
		}
		$this->huifu=$huifu;
		$this->assign('TypeArr',array('0'=>'关注回复','1'=>'文本回复','2'=>'图文回复'));
		$this->cate=M('cate')->select();
		$this->assign('list',$huifu);
		$this->display();
   }
   
    private function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
    //验证token
    public function validToken(){
        $url = 'https://mp.weixin.qq.com/debug/cgi-bin/sandboxinfo';
        
    }

        public function gzhuifu(){
        if(M('weixin_gz')->save($_POST)){
            $this->success('设置成功');
        }else{
            $this->error('设置失败');
        }
    }
	
	public function keyhf(){
            $huifu=M('weixin_huifu')->select();
            foreach($huifu as $k=>$v){
                $c=M('cate')->find($v['cid']);
                $huifu[$k]['catename']=$c['catename'];
            }
            $this->huifu=$huifu;
            $this->cate=M('cate')->select();
            $this->display();
	}

	public function eidtkey(){
        if(IS_POST){
			if($_POST['leixin']=='2'){
				$_POST['text']='';
			}
			if(M('weixin_huifu')->save($_POST)){
				$this->success('修改成功',U('/Admin/Weixin/keyhf'));
			}else{
				$this->error('修改失败内容没有被改变');
			}
        }else{
            $this->cate=M('cate')->select();
            $this->v=M('weixin_huifu')->find(I('get.id'));
            $this->display();
        }
	}
	public function delkey(){
		if(M('weixin_huifu')->delete(I('get.id'))){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
	
	public function setappid(){
		if(M('weixin_appid')->save(I('post.'))){
			$this->success('修改成功');
		}else{
			$this->error('修改失败，内容没有改变');
		}
	}
    public function menu(){
        if(IS_POST){
            if(I('post.pid')==0){
            $con=count(M('weixin_menu')->where('pid=0 and deleted=0')->select());
            if($con==3){
                $this->error('最多只能添加3个主菜单');
            }
        }		
            if(M('weixin_menu')->add(I('post.'))){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{		
            $this->appid=M('weixin_appid')->find();	
            $this->menu=M('weixin_menu')->where('pid=0 and deleted=0')->select();
            $menulist=M('weixin_menu')->where('pid=0 and deleted=0')->order('sort ASC')->select();
            foreach($menulist as $k=>$v){
                $er=M('weixin_menu')->where(array('pid'=>$v['id']))->order('sort ASC')->select();
                $menulist[$k]['sub']=$er;
            }
            $this->menulist=$menulist;
            $this->keys=M('weixin_huifu')->select();
            $this->display();
        }
    }
	public function sortcate(){
		$db = M('weixin_menu');

		foreach ($_POST as $id=>$sorts){
				$db->where(array( 'id'=>$id))->setField('sort',$sorts);		
		}
		$this->success('排序已改变');
	}
	

    public function delmenu(){
        $id = I('get.id');
        if(M('weixin_menu')->where(array('pid'=>$id,'deleted'=>0))->find()){
            $this->error('请先删除二级菜单');
        }
        if(M('weixin_menu')->where("id=$id")->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    
    public function addkeyword(){
		if(IS_POST){
			if(I('post.leixin')==0){
				if(I('post.text')==''){
					$this->error('回复内容不能为空');
				}
				M('weixin_huifu')->where('leixin=0')->save(array('text'=>I('post.text')));
				$this->success('更新成功');
			}else{
				if(M('weixin_huifu')->where(array('key'=>I('post.key')))->find()){
					$this->error('关键词已存在');
				}
				if(M('weixin_huifu')->add(I('post.'))){
					$this->success('添加成功');
				}else{
					$this->error('添加失败');
				}
			}
		}else{
			$list = M()->query('select * from jbr_article as ja left join jbr_article_data as jad on ja.id=jad.id');
			$this->assign('data',$list);
			$this->display();
		}
        
    }
	
	
    public function delKeyWord(){
        $id = I('get.id');
        if(M('weixin_huifu')->where("id=$id")->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
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

}