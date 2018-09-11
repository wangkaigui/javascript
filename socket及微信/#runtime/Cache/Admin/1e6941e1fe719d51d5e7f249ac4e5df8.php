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
<form method="post" class="js-ajax-form" action="<?php echo U('WxManage/addMenu');?>">

	<table width="100%" >
			<tbody>
				<tr>
					<th width="10%">序号</th>
					<th width="30%">关键字</th>
					<th width="30%">类型</th>
					<th width="20%">回复内容</th>
					<th width="10%">操作</th>
				</tr>
			</tbody>

			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["key"]); ?></td>
					<td><?php echo ($TypeArr[$vo['leixin']]); ?></td>																			
					<td><?php if($vo["leixin"] == 2): ?>文章ID：<?php echo ($vo["cid"]); else: echo ($vo["text"]); endif; ?></td>																			
					<td><a href="<?php echo U('WxManage/delKeyWord',array('id'=>$vo['id']));?>">删除</a></td>
				</tr>

				<?php if(is_array($voo['sub'])): $i = 0; $__LIST__ = $voo['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($v1["id"]); ?></td>
						<td><?php echo ($v1["title"]); ?></td>
						<td><?php if($v1['leixin'] == '1'): ?>关键词：<?php echo ($v1["keys"]); else: ?>链接跳转：<?php echo ($v1["url"]); endif; ?></td>	
						<td> <span class=""><input type="text" name="<?php echo ($v1["id"]); ?>" value="<?php echo ($v1["sort"]); ?>" class="sorts" alt="<?php echo ($v1["id"]); ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" /></span></td>											
						<td><a href="<?php echo U('WxManage/delKeyWord',array('id'=>$v1['id']));?>">删除</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
	</table>

	
			
	</div>

</form>
	
  
</div>
</body>