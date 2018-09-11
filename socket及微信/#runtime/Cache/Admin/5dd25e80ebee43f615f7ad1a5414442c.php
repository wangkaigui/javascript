<?php if (!defined('THINK_PATH')) exit(); if (!defined('SHUIPF_VERSION')) exit(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($Config["sitename"]); ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo ($config_siteurl); ?>statics/css/Base.css" />
</head>
<body>
<div id="login">
    <h1 class="tit">网站信息管理系统</h1>
    
    <form id="loginform" method="post" name="loginform" action="<?php echo U('Public/tologin');?>" >
        <dl class="login_dl">
            <dt><img src="<?php echo ($config_siteurl); ?>statics/images/Img_01.jpg" /></dt>
            <dd>
                <ul class="login_ul">
                    <li class="Icon_01"><input type="text" value="用户名" class="loginText input_T" id="u" name="username" /></li>
                    <li class="Icon_02"><input type="text" value="密码" class="loginText input_T" id="tp" /><input id="p"  maxlength='16' name="password" type="password" value="" class="loginText input_T hide" /></li>
                </ul>
                
                <p class="login_p">
                    <span><input type="submit" value="登录" class="loginBtn" /></span>
                    <em>
                        <input name="auto_login" type="checkbox" value="1" class="" />
                        下次自动登录
                    </em>
                </p> 
            </dd>
        </dl>
    </form>
</div>
<div id="foot" class="foot">
    <p>Content Manage System Powered By:©JBR-PCMS Version:V2.0 CopyRight 2014-2016.</p>
</div>
<div id="bgstretcher" class="bgstretcher" ></div>
<script type="text/javascript" src="<?php echo ($config_siteurl); ?>statics/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo ($config_siteurl); ?>statics/js/bgstretcher.js"></script>
<script type="text/javascript">
	$('body').bgStretcher({
		images: ['<?php echo ($config_siteurl); ?>statics/images/login-bg.jpg'],
		imageWidth: 1426,
		imageHeight: 791,
		transitionEffect: 'none',
		sequenceMode: 'normal',
		buttonPrev: '#cclb-btn-prev',
		buttonNext: '#cclb-btn-next',
		nextSlideDelay: '0',
		preloadImg: true
		//pagination: '#nav'
	});
</script>
<!--输入框清空事件-->
<script type="text/javascript">
$(function(){
	$("#u").focus(function(){
		if($(this).val() == this.defaultValue){
			$(this).val("");
		};
	});
	$("#u").blur(function(){
		if($(this).val() == ""){
			$(this).val(this.defaultValue);
		};
	});
	
	$("#tp").focus(function(){
		$("#tp").addClass("hide");
		$("#p").removeClass("hide");
		$("#p").focus();
	});
	
	$("#p").blur(function(){
		if($(this).val() == ""){
			$(this).val("");
			$("#tp").removeClass("hide");
			$("#p").addClass("hide");
		}
	});
});
</script>
</body>
</html>