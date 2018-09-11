<?php if (!defined('THINK_PATH')) exit(); if (!defined('SHUIPF_VERSION')) exit(); ?>
<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?php echo ($Config["sitename"]); ?></title>
<?php if (!defined('SHUIPF_VERSION')) exit(); ?><link href="<?php echo ($config_siteurl); ?>statics/css/admin_style.css" rel="stylesheet" />
<link href="<?php echo ($config_siteurl); ?>statics/js/artDialog/skins/default.css" rel="stylesheet" />
<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "<?php echo ($config_siteurl); ?>",
	JS_ROOT: "<?php echo ($config_siteurl); ?>statics/js/"
};
</script>
<script src="<?php echo ($config_siteurl); ?>statics/js/jquery.js"></script>
<script src="<?php echo ($config_siteurl); ?>statics/js/wind.js"></script>
<script src="<?php echo ($config_siteurl); ?>statics/js/uploadPreview.min.js"></script>
</head>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <?php  $getMenu = isset($Custom)?$Custom:D('Admin/Menu')->getMenu(); if($getMenu) { ?>
<div class="nav">
  <?php
 if(!empty($menuReturn)){ echo '<div class="return"><a href="'.$menuReturn['url'].'">'.$menuReturn['name'].'</a></div>'; } ?>
  <ul class="cc">
    <?php
 foreach($getMenu as $r){ $app = $r['app']; $controller = $r['controller']; $action = $r['action']; ?>
    <li <?php echo $action==ACTION_NAME ?'class="current"':""; ?>><a href="<?php echo U("".$app."/".$controller."/".$action."",$r['parameter']);?>"><?php echo $r['name'];?></a></li>
    <?php
 } ?>
  </ul>
</div>
<?php } ?>
  <div class="h_a">模型属性</div>
  <form action="<?php echo U();?>" method="post" class="J_ajaxForm" >
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

		<?php if(is_array($data)): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($k % 2 );++$k;?><tr id="articleId">
				<td><input type="radio" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($voo["id"]); ?>" title='<?php echo ($voo["title"]); ?>'></td>
				<td width="5%"><?php echo ($voo["id"]); ?></td>
				<td width="15%"><?php echo ($voo["title"]); ?></td>
				<td width="15%"><?php echo (date("Y-m-d H:i:s",$voo["updatetime"])); ?></td>																
				<td width="5%"><a href="<?php echo U('WxManage/delmenu',array('id'=>$voo['id']));?>">删除</a></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<div class="btn_wrap">
      <div class="btn_wrap_pd">
        <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>                
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo U('Content/delete',array('catid'=>$catid));?>">删除</button>
        <button class="btn" type="button" onClick="pushs()">添加消息</button>
      </div>
    </div>
    
	<div class="p10">
        <div class="pages"> <?php echo ($page); ?> </div>
    </div>
  </form>
	

	
 </div>
 <script src="<?php echo ($config_siteurl); ?>statics/js/common.js?v"></script>
 <script src="<?php echo ($config_siteurl); ?>statics/js/artDialog/dialog.js"></script>
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
		var userlist = eval('<?php echo ($thumblist); ?>');
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