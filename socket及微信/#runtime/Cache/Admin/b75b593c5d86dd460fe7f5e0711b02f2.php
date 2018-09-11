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
					<th width="10%">序号</th>
					<th width="10%">类型</th>
					<th width="30%">media_id</th>
					<th width="20%">时间</th>
					<th width="10%">操作</th>
				</tr>
			</tbody>

			<?php if(is_array($data)): $key = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr>
					<td><?php echo ($key); ?></td>
					<td><?php echo ($vo["type"]); ?></td>
					<td><?php echo ($vo["media_id"]); ?></td>																			
					<td><?php echo (date("Y-m-d H:i:s",$vo["created"])); ?></td>																		
					<td>
						<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit" formaction="<?php echo U('MaterialManage/previewMsg',array('media_id'=>$vo['media_id']));?>">发送手机预览</button>
						<button class="btn btn_submit mr10 J_ajax_submit_btn" type="button" media_id='<?php echo ($vo["media_id"]); ?>' onclick="sendAllMsg($(this).attr('media_id'));">群发消息</button>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>

	
			
	</div>

</form>
	
  
</div>
</body>
 <script src="<?php echo ($config_siteurl); ?>statics/js/common.js?v"></script>
 <script src="<?php echo ($config_siteurl); ?>statics/js/artDialog/dialog.js"></script>
<script>
	function sendAllMsg(media_id){
		var str="<tr id='msgId'><td><input type='checkbox'   value=''>全部</td></tr>";
		var groupids = '';
		var userlist = eval('<?php echo ($userlist); ?>');
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