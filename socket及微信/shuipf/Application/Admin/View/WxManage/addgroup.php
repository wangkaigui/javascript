<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>

<style>
	.reduceDis{display:none}
	.reduceBlo{display:block}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  
  <form action="{:U('WxManage/addgroup')}" method="post" >
  
	
    <div class="table_full">
	
      <table   class="table_form">
		<tr style="width:80px;">
			<th>请输入分组名称：</th>
			<td class="y-bg"><input type="text" class="input" name="groupname" size="30"  /></td>
		</tr>
		
		<tbody>
			<tr>
				<th width="3%">序号<input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">全选</th>
				<th width="3%">图像</th>
				<th width="6%">昵称</th>
				<th width="8%">opendid</th>
				<th width="5%">所在分组</th>
				<th width="5%">性别</th>
				<th width="5%">国家</th>
				<th width="5%">省</th>
				<th width="5%">城市</th>
				
			</tr>
		</tbody>

		<volist name="data" id="voo" key="ke">
			<tr id="openids">
				<td>{$ke}<input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="openid" value="{$voo.openid}"></td>
				<td> <img src="{$voo['headimgurl']}" style="height: 25px;width: 25px;" /></td>
				<td>{$voo.nickname}</td>
				<td>{$voo.openid}</td>
				<td>{$voo.groupname}</td>
				<td>{$sexArr[$voo['sex']]}</td>
				<td>{$voo.country}</td>
				<td>{$voo.province}</td>
				<td>{$voo.city}</td>
			</tr>
		</volist>

		
      </table>
    </div>
	
    <div class="">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="button">添加</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
<script src="{$config_siteurl}statics/js/artDialog/dialog.js"></script>
</body>
</html>

<script>
$(":button").click(function(){
	var openids = "";
	var groupname = $.trim($("input[name='groupname']").val());
	$("#openids input[type=checkbox]").each(function(){
		if($(this).attr('checked')=='checked'){
			var openid = $(this).val();
			openids+="'"+openid+"'"+",";
		}
	})
	if(openids==""){
		artDiaLog('未选中任何用户！');
	}else if(groupname==''){
		artDiaLog('分组名称不能为空！');
	}else{
		$.ajax({
			type: "POST",
			url: "index.php?g=Admin&m=WxManage&a=addgroup",
			dataType:'json',
			data: {
				'openids':openids,
				'groupname':groupname,
			},
			success: function(data){	
				artDiaLog('添加分组成功');
			},
			error:function(){
				artDiaLog('未知错误');
			},
		});
	}
});

function artDiaLog(msg){
	var d = dialog({
		title: '警告',
		content: msg,
		okValue: '确 定'
	});
	d.show();
	return false;
}
</script>