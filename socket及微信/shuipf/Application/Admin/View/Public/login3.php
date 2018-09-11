<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="{$config_siteurl}statics/css/Base.css" />
<title>{$Config.sitename}<</title>
<meta name="generator" content="CMS" />
<admintemplate file="Admin/Common/Js"/>
</head>

<body>
<div class="cntBg">
	<ul class="cntBg_ul">
    	<li><img src="{$config_siteurl}statics/Images/Logo.png" /></li>
         <form id="loginform" method="post" name="loginform" action="{:U('Public/tologin')}"   >
        <li class="cntBg_li">
        	<span><img src="{$config_siteurl}statics/images/Icon_01.jpg" /></span>
        	<input type="text" value="账号名" class="input_T" id="u" name="username"  />
        </li>
        
        <li class="cntBg_li">
        	<span><img src="{$config_siteurl}statics/images/Icon_02.jpg" /></span>
        	<input type="password" value="1234" id="p" name="password" tabindex="2" class="input_T input_txt" />
        </li>
        
        <li class="cntBg_code">
        	<input  id="verifycode" name="code" maxlength=5 tabindex="3" class="input_T input_txt" type="text" value=""  placeholder="请输入验证码" />
        	<img class="yanzheng_img change_img" id="code_img" src="" alt="{:U('Api/Checkcode/index','code_len=4&font_size=20&width=130&height=50&font_color=&background=')}"> 
        </li>
        <li><input type="submit" value="" class="LsBtn" /></li>
        </form>
    </ul>
</div>
<script src="{$config_siteurl}statics/js/jquery.js" type="text/javascript"></script>
<!--输入框清空事件-->
<script type="text/javascript">
$(function(){
	$(".input_T").click(function(){
		if($(this).val() == this.defaultValue){
			$(this).val("");
		};
	});
	$(".input_T").blur(function(){
		if($(this).val() == ""){
			$(this).val(this.defaultValue);
		};
	});
});
</script>
<script>
//刷新广告
function refreshs(){
	document.getElementById('code_img').src='{:U('Api/Checkcode/index','code_len=4&font_size=20&width=130&height=50&font_color=&background=&refresh=1')}&time='+Math.random();void(0);
}
$(function(){
	$('#verifycode').focus(function(){
		$('img.change_img').trigger("click");
	});
}); 
$(function(){
	//加载页面加载验证码
	refreshs();
	//点击验证码时切换验证码图片
	$('#code_img').click(function(){
			refreshs();
		});
});
</script>
</body>
</html>