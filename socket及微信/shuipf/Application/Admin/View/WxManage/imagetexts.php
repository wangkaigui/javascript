<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  <form action="{:U()}" method="post" class="J_ajaxForm" >
	<table width="100%" >
		<tbody>
			<tr>
				<th width="5%" >选择</th>
				<th width="5%">文章ID</th>
				<th width="15%">标题</th>
				<th width="15%">时间</th>
				<th width="5%">操作</th>
			</tr>
		</tbody>

		<volist name="data" id="voo" key="k">
			<tr id="articleId">
				<td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$voo.id}"></td>
				<td width="5%">{$voo.id}</td>
				<td width="15%">{$voo.title}</td>
				<td width="15%">{$voo.updatetime|date="Y-m-d H:i:s",###}</td>																
				<td width="5%"><a href="{:U('WxManage/delmenu',array('id'=>$voo['id']))}">删除</a></td>
			</tr>

		</volist>
	</table>
	
	<div class="btn_wrap">
      <div class="btn_wrap_pd">
        <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>                
        <button class="btn J_ajax_submit_btn" type="submit" data-action="{:U('Content/delete',array('catid'=>$catid))}">删除</button>
        <button class="btn" type="button" onClick="pushs()">消息推送</button>
      </div>
    </div>
    
	<div class="p10">
        <div class="pages"> {$page} </div>
    </div>
  </form>
	

	
 </div>
 <script src="{$config_siteurl}statics/js/common.js?v"></script>
 <script src="{$config_siteurl}statics/js/artDialog/dialog.js"></script>
 <script>
	function pushs() {
		var str="<tr id='msgId'><td><input type='checkbox'   value=''>全部</td></tr>";
		var groupids='';
		var articleId = '';
		$("#articleId input[type=checkbox]").each(function(){
			if($(this).attr('checked')=='checked'){
				articleId+=$(this).val()+",";
			}
		})
		if(articleId==''){
			artDiaLog('未选中任何文章');
			return false;
		}
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
				pushImgMsg(groupids,articleId);
			},
			cancelValue: '取消',
			cancel: function() {
				
			}
		});

		d.showModal();
        

	}
	
	function pushImgMsg(groupids,articleId){
		
		$.ajax({
			type: "POST",
			url: "index.php?g=Admin&m=WxManage&a=pushImgMsg",
			dataType:'json',
			data: {
				'groupids':groupids,
				'articleId':articleId,
			},
			success: function(data){
				artDiaLog('推送成功：'+data.sucNum+' 推送失败：'+data.errNum);
				
			},
			error:function(){
				artDiaLog('未知错误');
			},
		});
	}
	
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