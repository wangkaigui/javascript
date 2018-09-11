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
<form method="post" class="js-ajax-form" action="<?php echo U('MaterialManage/previewMsg');?>">

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

			<?php if(is_array($data)): $key = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr id='selectId'>
					<td><?php echo ($key); ?><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["article_id"]); ?>" ispic='<?php echo ($vo["show_cover_pic"]); ?>'></td>
					<td><?php echo ($vo["article_id"]); ?></td>
					<td><?php echo ($vo["title"]); ?></td>
					<td><?php echo ($vo["thumb_media_id"]); ?></td>																			
					<td><?php echo ($vo["thumb_media_name"]); ?></td>																			
					<td><?php echo ($typeArr[$vo['show_cover_pic']]); ?></td>																			
					<td><?php echo ($vo["content_source_url"]); ?></td>																			
					<td><?php echo ($vo["created"]); ?></td>																		
					
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>

	
	<div class="btn_wrap">
      <div class="btn_wrap_pd">
        <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>                
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo U('Content/delete',array('catid'=>$catid));?>">删除</button>
        <button class="btn" type="button" onClick="pushs()">消息推送</button>
      </div>
    </div>
    
	<div class="p10">
        <div class="pages"> <?php echo ($page); ?> </div>
    </div>
  </form>
	
  
</div>
</body>

<script src="<?php echo ($config_siteurl); ?>statics/js/common.js?v"></script>
<script src="<?php echo ($config_siteurl); ?>statics/js/artDialog/dialog.js"></script>

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