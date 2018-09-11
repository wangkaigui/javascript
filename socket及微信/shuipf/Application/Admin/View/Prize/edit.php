<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<link type="text/css" rel="stylesheet" href="{$config_siteurl}statics/css/Base.css" />

<script type="text/javascript" src="{$config_siteurl}statics/DatePicker/WdatePicker.js"></script>

<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <div class="lsList" style="background:#fff;">
    <form enctype="multipart/form-data" id="myform" class="J_ajaxForm" method="post" action="{:U(Coupon/add)}">
    <input name="id" value="{$data.id}" type="hidden"/>
    <div class="clearfix">
        <ul class="fl lsList_ul">
            <li>
                <span>奖项标题 （如特等奖、一等奖。。。)</span>
                <input value="{$data.title}" name="title" type="text" class="listText" />
            </li>
            
            <li>
                <span>奖项 （如iphone、吹风机等） </span>
                <input name="name" type="text" value="{$data.name}" class="listText" />
            </li>
            <li>
                <span>奖品数量</span>
                <input name="num" type="text" value="{$data.num}" class="listText" />
            </li>
            
             <li class="listBox">
                <span>奖品图片</span>
                <a href="#" class="lsList_a cover"><img id="cover" src="{$data.img}" /></a>
            	<input type="file" name="img" class="listFile cover_up"  />
            </li>
            
           	<li>
                <span>排序号 </span>
                <input name="sort" type="text" value="{$data.sort}" class="listText" />
            </li>
            
            <li>
                <input type="submit" value="确&nbsp;定" class="listBtn" />
            </li>
        </ul>
    </div>
    </form>
	</div>
</div>
</body>

<script type="text/javascript">
	$(function () {
     	$(".cover_up").uploadPreview({ Img: "cover", Width: 120, Height: 120});
     });
	$(function(){
		$(".cover").click(function(){
			$(".cover_up").click();
			return false;
		});
	})
</script>	
</html>
