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
				<td><input type="radio" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$voo.id}" title='{$voo.title}'></td>
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
        <button class="btn" type="button" onClick="pushs()">添加消息</button>
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
		var str="<span id='addWxMsgId'><input type='checkbox' value='1' name='is_pic'>是否为封面<br/>请选择缩略图<select id='thumb_id' name='thumb_id'  style='margin:8px;'>";
		var article_id = '';
		var titles = '';
		$("#articleId input[type=radio]").each(function(){
			if($(this).attr('checked')=='checked'){
				article_id+=$(this).val();
				titles+=$(this).attr('title');
			}
		})
		if(article_id==''){
			artDiaLog('未选中任何文章');
			return false;
		}
		var userlist = eval('{$thumblist}');
		$.each(userlist,function(k,v){
			str+="<option value='"+v.media_id+"'>"+v.title+"</option>";
		});
		str+="</select><br/>阅读全文地址<input type='text' name='content_source_url' style='margin:8px;'></span>";
		
		var d = dialog({
			title: '消息',
			content: str,
			okValue: '确 定',
			ok: function() {
				var thumb_media_id = $("#thumb_id option:selected").val();
				var thumb_media_name = $("#thumb_id option:selected").text();
				addWxMsg(thumb_media_id,article_id,titles,thumb_media_name);
			},
			cancelValue: '取消',
			cancel: function() {
				
			}
		});

		d.showModal();
        

	}
	
	function addWxMsg(thumb_media_id,article_id,titles,thumb_media_name){
		var content_source_url = $("input[name='content_source_url']").val();
		var show_cover_pic = '';
		$("#addWxMsgId input[type=checkbox]").each(function(){
			if($(this).attr('checked')=='checked'){
				show_cover_pic+=$(this).val();
			}
		})
		$.ajax({
			type: "POST",
			url: "index.php?g=Admin&m=MaterialManage&a=addWxMsg",
			dataType:'json',
			data: {
				'thumb_media_id':thumb_media_id,
				'show_cover_pic':show_cover_pic,
				'article_id':article_id,
				'content_source_url':content_source_url,
				'title':titles,
				'thumb_media_name':thumb_media_name
			},
			success: function(data){
				artDiaLog(data.msg);
				
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