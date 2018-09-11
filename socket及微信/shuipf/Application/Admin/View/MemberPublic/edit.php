<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	<ul class="lsList_ul">
	<form name="myform" enctype="multipart/form-data" class="J_ajaxForm" action="{:U('edit')}&id={$lists['id']}" method="post">
    	<li>
        	<span><em>*</em>公众号名称</span>
            <input type="text" name="public_name" value="{$lists['public_name']}" class="listText" />
        </li>
        
        <li>
        	<span><em>*</em>公众号原始ID<i>(请正确填写，保存后不能再修改，且无法接受到微信的信息)</i></span>
            <input type="text" value="{$lists['public_id']}" class="listText" />
        </li>
        
        <li>
        	<span><em>*</em>微信号</span>
            <input type="text" name="wechat" value="{$lists['wechat']}" class="listText" />
        </li>
        
        <li class="listBox">
        	<span>公众号头像</span>
            <a href="#" class="lsList_a lsList_a1"><img id="ImgPr" src="{$lists['headface_url']}" /></a>
			<input type="file" name="headface_url" id="up" class="listFile" />
			<input type="hidden" value="">
        </li>
        
        <li>
        	<span>公众号类型</span>
            <p><input type="radio" name="type" value="0" <if condition="$lists['type'] eq 0"> checked="checked"</if> /><b>订阅号</b></p>
            <p><input type="radio" name="type" value="1"  <if condition="$lists['type'] eq 1"> checked="checked"</if> /><b>服务号</b></p>
        </li>
        
        <li>
        	<span>AppId<i>(认证服务号的AppId)</i></span>
            <input name="appid" type="text" value="{$lists['appid']}" class="listText" />
        </li>
        
        <li>
        	<span>Secret<i>(认证服务号的Secret)</i></span>
            <input name="secret" type="text" value="{$lists['appid']}" class="listText" />
        </li>
        
        <li>
        	<input type="submit" value="确&nbsp;定" class="listBtn" />
        </li>
		</form>
    </ul>
</div>
</div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>

<script type="text/javascript">
	 $(function () {
            $("#up").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120 });
        });
</script>
<script type="text/javascript">
	$(function(){
		$(".lsList_a").click(function(){
			$(".listFile").click();
			return false;
		});
	})
</script>