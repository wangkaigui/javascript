<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  <form action="{:U('WxManage/updateUser')}" method="post" class="J_ajaxForm" >
	<table width="100%" >
		<tbody>
			<tr>
				<th width="3%">序号</th>
				<th width="3%">类型</th>
				<th width="3%">名称</th>
				<th width="5%">图像</th>
				<th width="5%">media_id</th>
				<th width="8%">url</th>
				
			</tr>
		</tbody>

		<volist name="data" id="voo" key="key">
			<tr>
				<td>{$key}</td>
				<td><if condition="$voo.type eq 'image'">图片类型<elseif condition="$voo.type eq 'thumb'"/>缩略图类型<elseif condition="$voo.type eq 'video'"/>视频类型<elseif condition="$voo.type eq 'voice'"/>语音类型</if></td>
				<td>{$voo.title}</td>
				<td> <img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl={$voo['url']}" style="height: 25px;width: 25px;" /></td>
				<td>{$voo.media_id}</td>
				<td><a href="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl={$voo.url}">http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl={$voo.url}</a></td>
			</tr>
		</volist>
	</table>
	
	<div class="btn_wrap_pd">
		<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">更新用户列表</button>
     </div>
	 
	 <div class="p10">
        <div class="pages"> {$page} </div>
    </div>
</form>
