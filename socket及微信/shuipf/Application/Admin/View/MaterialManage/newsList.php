<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
<form method="post" class="js-ajax-form" action="{:U('MaterialManage/previewMsg')}">

	<table width="100%" >
			<tbody>
				<tr>
					<th width="10%">序号</th>
					<th width="10%">类型</th>
					<th width="30%">media_id</th>
					<th width="20%">时间</th>
					<th width="10%">操作</th>
				</tr>
			</tbody>

			<volist name="data" id="vo" key='key'>
				<tr>
					<td>{$key}</td>
					<td>{$vo["type"]}</td>
					<td>{$vo.media_id}</td>																			
					<td>{$vo.created|date="Y-m-d H:i:s",###}</td>																		
					<td>
						<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit" formaction="{:U('MaterialManage/previewMsg',array('media_id'=>$vo['media_id']))}">发送手机预览</button>
						<button class="btn btn_submit mr10 J_ajax_submit_btn" type="button" media_id='{$vo.media_id}' onclick="sendAllMsg($(this).attr('media_id'));">群发消息</button>
					</td>
				</tr>

			</volist>
	</table>

	
			
	</div>

</form>
	
  
</div>
</body>
 <script src="{$config_siteurl}statics/js/common.js?v"></script>
 <script src="{$config_siteurl}statics/js/artDialog/dialog.js"></script>
<script>
	function sendAllMsg(media_id){
		var str="<tr id='msgId'><td><input type='checkbox'   value=''>全部</td></tr>";
		var groupids = '';
		var userlist = eval('{$userlist}');
		$.each(userlist,function(k,v){
			str+="<tr id='msgId'><td><input type='checkbox'   value='"+v.groupid+"'>"+v.groupname+"</td></tr>";
		});
		
		var d = dialog({
			title: '消息',
			content: str,
			okValue: '确 定',
			ok: function() {
				$("#msgId input[type=checkbox]").each(function(){
					if($(this).attr('checked')=='checked'){
						groupids+=$(this).val()+",";
					}
				})
				sendWxMsg(groupids,media_id);
			},
			cancelValue: '取消',
			cancel: function() {
				
			}
		});

		d.showModal();
        
	}
	
	
function sendWxMsg(groupids,media_id){
	$.ajax({
		type: "POST",
		url: "index.php?g=Admin&m=MaterialManage&a=sendWxMsg",
		dataType:'json',
		data: {
			'groupids':groupids,
			'media_id':media_id,
		},
		success: function(data){
			if(data.errcode==0){
				artDiaLog('提示','发送成功'+data.errmsg);
			}else{
				artDiaLog('提示',data.errmsg);
			}
			
		},
		error:function(){
			artDiaLog('提示','未知错误');
		},
	});
}
	
function artDiaLog(title,msg){
	var d = dialog({
		title: title,
		content: msg,
		okValue: '确 定'
	});
	d.show();
	return false;
}
</script>