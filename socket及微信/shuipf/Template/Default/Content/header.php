<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
    <div class="header">
    	<div class="Box  topBox">
			<a class="logo" href="index.php"><img  class="png_bg" src=".{$config_siteurl}statics/default/Images/logo.png" /></a>
            <div class="menu">
            	<a class="<if condition="$catid eq null">focus</if>" href="index.php">首页</a>
                <a class="<if condition="$catid eq 3">focus</if>" href="{:getcategory('3',url)}">关于我们</a>
                <a class="<if condition="$catid eq 6">focus</if>" href="{:getcategory('6',url)}">产品展示</a>
                <a class="<if condition="$catid eq 14">focus</if>" href="{:getcategory('14',url)}">客户案例</a>
                <a class="<if condition="$catid eq 16">focus</if>" href="{:getcategory('16',url)}">联系我们</a>
                <a class="<if condition="$catid eq 17">focus</if>" href="{:getcategory('17',url)}">人才招聘</a>
            </div>
        </div>
    </div>
    <div class="qh" style=" position:fixed; right:0; top:0; width:100px; height:30px;">
	<a href="http://www.whglyq.com/" style="display:block; width:45px; height:30px; text-align:center; line-height:30px; float:left; color:#000;">中文版</a>
	<span style="display:block; width:10px; height:30px;float:left; text-align:center; line-height:30px; color:#000;">|</span><a href="http://www.whglyq.com/en" style="display:block; width:45px; height:30px;float:left; text-align:center; line-height:30px; color:#000;">English</a></div>