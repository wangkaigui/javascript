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
					<th width="5%" >序号 选择</th>
					<th width="5%">文章id</th>
					<th width="18%">文章标题</th>
					<th width="18%">缩略图id</th>
					<th width="15%">缩略名称</th>
					<th width="5%">是否封面</th>
					<th width="10%">全文地址</th>
					<th width="8%">时间</th>
					
				</tr>
			</tbody>

			<volist name="data" id="vo" key='key'>
				<tr id='selectId'>
					<td>{$key}<input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.article_id}" ispic='{$vo.show_cover_pic}'></td>
					<td>{$vo.article_id}</td>
					<td>{$vo.title}</td>
					<td>{$vo.thumb_media_id}</td>																			
					<td>{$vo.thumb_media_name}</td>																			
					<td>{$typeArr[$vo['show_cover_pic']]}</td>																			
					<td>{$vo.content_source_url}</td>																			
					<td>{$vo.created}</td>																		
					
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
</body>

<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script src="{$config_siteurl}statics/js/artDialog/dialog.js"></script>

<script>
	function pushs(){
		var i=0;
		var n=0;
		var articleId = '';
		$("#selectId input[type=checkbox]").each(function(){
			if($(this).attr('checked')=='checked'){
				articleId +=$(this).val()+',';
				i++;
				if($(this).attr('ispic')==1){
					n++;
				}
			}
		});
		if(articleId==''){
			artDiaLog('请选择需要上传的消息');
			return false;
		}
		if(i>9){
			artDiaLog('消息最大不能超过9条');
			return false;
		}
		if(n>1){
			artDiaLog('封面消息只能选择1条');
			return false;
		}
		$.ajax({
			type: "POST",
			url: "index.php?g=Admin&m=MaterialManage&a=uploadNews",
			dataType:'json',
			data: {
				'articleId':articleId
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
