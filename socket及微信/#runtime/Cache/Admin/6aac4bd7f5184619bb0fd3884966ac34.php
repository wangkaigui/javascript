<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<link href="/statics/default/css/main.css" rel="stylesheet" type="text/css" />
<script src='//cdn.bootcss.com/socket.io/1.3.7/socket.io.js'></script>
<script src='//cdn.bootcss.com/jquery/1.11.3/jquery.js'></script>
<script src='/statics/default/js/notify.js'></script>
</head>
<body>

<div class="notification sticky hide">
    <p id="content"> </p>
</div>
<div class="wrapper">
    <div style="width:850px;">
    <input type="text" name="content" value=''>
	<input type="button" value="发送消息" onclick="send();">
	<input type='hidden' value='' id='toUser'>
	在线用户列表<span id='online_box'></span>
	<span id='userlist'>
	
	</span>
    <script>
        // 使用时替换成真实的uid，这里方便演示使用时间戳
        //var uid = Date.parse(new Date());
		var uid=10010;
		//获取消息记录
		var msg='';
		$.post("index.php?m=Index&a=getChatContent",{'uid':uid},function(result){
			//alert(result);
			$.each(eval(result),function(k,v){
				msg+='历史消息：'+v.content+'<br/>';
			});
			$('#content').append(msg);
		});
		
        $('#send_to_one').attr('href', 'http://'+document.domain+':2121/?type=publish&content=%E6%B6%88%E6%81%AF%E5%86%85%E5%AE%B9&to='+uid);
        $('.uid').html(uid);
		$('#send_to_all').attr('href', 'http://'+document.domain+':2121/?type=publish&content=%E6%B6%88%E6%81%AF%E5%86%85%E5%AE%B9');
        $('.uid').html(uid);
        $('.domain').html(document.domain);
    </script>
</div>

<script>
$(document).ready(function () {
    // 连接服务端
    var socket = io('http://'+document.domain+':2120');
    // 连接后登录
    socket.on('connect', function(){
    	socket.emit('login', uid);
    });
    // 后端推送来消息时
    socket.on('new_msg', function(msg){
         $('#content').append('收到消息：'+msg+'<br/>');
		 //alert(msg);
         $('.notification.sticky').notify();
    });
    // 后端推送来在线数据时
	
    socket.on('update_online_count', function(data){
		/*$.post("<?php echo U('Chat/ajaxSetUser');?>",{'uid':uid},function(result){
			
		});*/
		//i++;
		//str+=data+'<br/>';
		//alert(data);
		/*for(var i in data){
			alert(data[i]);
		}*/
		var str="";
		var i=0;
		$.each(eval(data),function(i,val){ 
		  //alert(val);
		 
		  i=i+1;
		  str+='<a href="javascript:;" onclick="setUid('+val+');" uid="'+val+'">游客'+i+'：发送消息</a><br/>';
		});
	$("#userlist").html(str);
	$('#online_box').html(i);
	
    });
	
});

function setUid(uid){
	$("#toUser").val(uid);
}

function send(){
	//alert($("#toUser").val());
	
	$.post("<?php echo U('Chat/send');?>",{'uid':$("#toUser").val(),'content':$("input[name='content']").val()},function(result){
		if(result=="'ok'"){
			$('#content').append('发送消息：'+$("input[name='content']").val()+'<br/>');
			$("input[name='content']").val(" ");
		}
	});
}
</script>
<div id="footer">
<center id="online_box"></center>
<center><p style="font-size:11px;color:#555;"> Powered by <a href="http://www.workerman.net/web-sender" target="_blank"><strong>web-msg-sender!</strong></a></p></center>
</div>
</body>
</html>