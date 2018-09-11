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
				<th width="3%">类型</th>
				<th width="3%">名称</th>
				<th width="5%">图像</th>
				<th width="5%">media_id</th>
				<th width="8%">url</th>
				
			</tr>
		</tbody>

		<?php if(is_array($data)): $key = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($key % 2 );++$key;?><tr>
				<td><?php echo ($key); ?></td>
				<td><?php if($voo["type"] == 'image'): ?>图片类型<?php elseif($voo["type"] == 'thumb'): ?>缩略图类型<?php elseif($voo["type"] == 'video'): ?>视频类型<?php elseif($voo["type"] == 'voice'): ?>语音类型<?php endif; ?></td>
				<td><?php echo ($voo["title"]); ?></td>
				<td> <img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=<?php echo ($voo['url']); ?>" style="height: 25px;width: 25px;" /></td>
				<td><?php echo ($voo["media_id"]); ?></td>
				<td><a href="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=<?php echo ($voo["url"]); ?>">http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=<?php echo ($voo["url"]); ?></a></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<div class="btn_wrap_pd">
		<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">更新用户列表</button>
     </div>
	 
	 <div class="p10">
        <div class="pages"> <?php echo ($page); ?> </div>
    </div>
</form>