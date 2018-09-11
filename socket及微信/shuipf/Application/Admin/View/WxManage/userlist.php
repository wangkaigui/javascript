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
				<th width="5%">图像</th>
				<th width="8%">昵称</th>
				<th width="8%">opendid</th>
				<th width="5%">性别</th>
				<th width="5%">国家</th>
				<th width="5%">省</th>
				<th width="5%">城市</th>
				
			</tr>
		</tbody>

		<volist name="data" id="voo">
			<tr>
				<td>{$voo.id}</td>
				<td> <img src="{$voo['headimgurl']}" style="height: 25px;width: 25px;" /></td>
				<td>{$voo.nickname}</td>
				<td>{$voo.openid}</td>
				<td>{$sexArr[$voo['sex']]}</td>
				<td>{$voo.country}</td>
				<td>{$voo.province}</td>
				<td>{$voo.city}</td>
			</tr>
		</volist>
	</table>
	
	<div class="btn_wrap_pd">
		<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">更新用户列表</button><span style='color:red;'>*请勿频繁更新列表，超过微信日接口调用上限后服务将不可用</span>
     </div>
	 
	 <div class="p10">
        <div class="pages"> {$page} </div>
    </div>
</form>
