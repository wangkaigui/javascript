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
  <form action="<?php echo U('WxManage/updateUser');?>" method="post" class="J_ajaxForm" >
	<table width="100%" >
		<tbody>
			<tr>
				<th width="3%">序号</th>
				<th width="5%">图像</th>
				<th width="8%">昵称</th>
				<th width="8%">opendid</th>
				<th width="5%">性别</th>
				<th width="5%">国家</th>
				<th width="5%">省</th>
				<th width="5%">城市</th>
				
			</tr>
		</tbody>

		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ($voo["id"]); ?></td>
				<td> <img src="<?php echo ($voo['headimgurl']); ?>" style="height: 25px;width: 25px;" /></td>
				<td><?php echo ($voo["nickname"]); ?></td>
				<td><?php echo ($voo["openid"]); ?></td>
				<td><?php echo ($sexArr[$voo['sex']]); ?></td>
				<td><?php echo ($voo["country"]); ?></td>
				<td><?php echo ($voo["province"]); ?></td>
				<td><?php echo ($voo["city"]); ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<div class="btn_wrap_pd">
		<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">更新用户列表</button><span style='color:red;'>*请勿频繁更新列表，超过微信日接口调用上限后服务将不可用</span>
     </div>
	 
	 <div class="p10">
        <div class="pages"> <?php echo ($page); ?> </div>
    </div>
</form>