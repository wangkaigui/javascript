<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	<ul class="lsList_ul">
	<form name="myform" class="J_ajaxForm" action="{:U('add')}" method="post">
    	<li>
        	<span><em>*</em>排序号</span>
            <input type="text" name="sort" value="0" class="listText" style="width:50px;text-align:center;"/>
        </li>
        
        <li>
        	<span><em>*</em>一级菜单 <i>（如果是一级菜单，选择“无”即可）</i></span>
            <select name="pid" class="listSel">
                <option value="0">无</option>
				<volist name="category" id="vo">
				<option value="{$vo.id}">{$vo.title}</option>
				</volist>
			</select>
        </li>
        
        <li>
        	<span><em>*</em>菜单名<i>（可创建最多 3 个一级菜单，每个一级菜单下可创建最多 5 个二级菜单。编辑中的菜单不会马上被用户看到，请放心填写）</i></span>
            <input type="text" name="title" value="" class="listText" />
        </li>
        
        <li>
        	<span>关联关键词<i>(关联关键词与URL选填一项)</i></span>
            <input name="keyword" type="text" value="" class="listText" />
        </li>
        
        <li>
        	<span>关联URL<i>(关联关键词与URL选填一项)</i></span>
            <input name="url" type="text" value="" class="listText" />
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