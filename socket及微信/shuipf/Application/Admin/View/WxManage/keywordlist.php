<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
<form method="post" class="js-ajax-form" action="{:U('WxManage/addMenu')}">

	<table width="100%" >
			<tbody>
				<tr>
					<th width="10%">序号</th>
					<th width="30%">关键字</th>
					<th width="30%">类型</th>
					<th width="20%">回复内容</th>
					<th width="10%">操作</th>
				</tr>
			</tbody>

			<volist name="list" id="vo">
				<tr>
					<td>{$vo.id}</td>
					<td>{$vo.key}</td>
					<td>{$TypeArr[$vo['leixin']]}</td>																			
					<td><if condition='$vo.leixin eq 2'>文章ID：{$vo.cid}<else />{$vo.text}</if></td>																			
					<td><a href="{:U('WxManage/delKeyWord',array('id'=>$vo['id']))}">删除</a></td>
				</tr>

				<volist name="voo['sub']" id="v1">
					<tr>
						<td>{$v1.id}</td>
						<td>{$v1.title}</td>
						<td><if condition="$v1['leixin'] eq '1'">关键词：{$v1.keys}<else />链接跳转：{$v1.url}</if></td>	
						<td> <span class=""><input type="text" name="{$v1.id}" value="{$v1.sort}" class="sorts" alt="{$v1.id}" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" /></span></td>											
						<td><a href="{:U('WxManage/delKeyWord',array('id'=>$v1['id']))}">删除</a></td>
					</tr>
			   </volist>

			</volist>
	</table>

	
			
	</div>

</form>
	
  
</div>
</body>