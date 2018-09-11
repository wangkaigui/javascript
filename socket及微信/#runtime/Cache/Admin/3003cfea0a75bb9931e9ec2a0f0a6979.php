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

<style>
	.reduceDis{display:none}
	.reduceBlo{display:block}
</style>
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
  
  <form action="<?php echo U('WxManage/addgroup');?>" method="post" >
  
	
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

		<?php if(is_array($data)): $ke = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($ke % 2 );++$ke;?><tr id="openids">
				<td><?php echo ($ke); ?><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="openid" value="<?php echo ($voo["openid"]); ?>"></td>
				<td> <img src="<?php echo ($voo['headimgurl']); ?>" style="height: 25px;width: 25px;" /></td>
				<td><?php echo ($voo["nickname"]); ?></td>
				<td><?php echo ($voo["openid"]); ?></td>
				<td><?php echo ($voo["groupname"]); ?></td>
				<td><?php echo ($sexArr[$voo['sex']]); ?></td>
				<td><?php echo ($voo["country"]); ?></td>
				<td><?php echo ($voo["province"]); ?></td>
				<td><?php echo ($voo["city"]); ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>

		
      </table>
    </div>
	
    <div class="">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="button">添加</button>
      </div>
    </div>
  </form>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js"></script>
<script src="<?php echo ($config_siteurl); ?>statics/js/artDialog/dialog.js"></script>
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