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
  <div class="h_a">搜索</div>
  <form method="post" action="<?php echo U('index');?>">
  <div class="search_type cc mb10">
    <div class="mb10"> <span class="mr20">
    搜索类型：
    <select class="select_2" name="status" style="width:70px;">
        <option value='' <?php if($_GET['status'] == ''): ?>selected<?php endif; ?>>不限</option>
                <option value="0" <?php if($_GET['status'] == '0'): ?>selected<?php endif; ?>>error</option>
                <option value="1" <?php if($_GET['status'] == '1'): ?>selected<?php endif; ?>>success</option>
      </select>
      用户ID：<input type="text" class="input length_2" name="uid" size='10' value="<?php echo ($_GET["uid"]); ?>" placeholder="用户ID">
      IP：<input type="text" class="input length_2" name="ip" size='20' value="<?php echo ($_GET["ip"]); ?>" placeholder="IP">
      时间：
      <input type="text" name="start_time" class="input length_2 J_date" value="<?php echo ($_GET["start_time"]); ?>" style="width:80px;">
      -
      <input type="text" class="input length_2 J_date" name="end_time" value="<?php echo ($_GET["end_time"]); ?>" style="width:80px;">
      <button class="btn">搜索</button>
      </span> </div>
  </div>
    <div class="table_list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" width="30">ID</td>
            <td align="center" width="50" >用户ID</td>
            <td align="center" width="60">状态</td>
            <td>说明</td>
            <td>GET</td>
            <td align="center" width="150">时间</td>
            <td align="center" width="120">IP</td>
          </tr>
        </thead>
        <tbody>
          <?php if(is_array($logs)): $i = 0; $__LIST__ = $logs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
              <td align="center"><?php echo ($vo["id"]); ?></td>
              <td align="center"><?php echo ($vo["uid"]); ?></td>
              <td align="center"><?php if($vo['status'] == '1'): ?>success<?php else: ?>error<?php endif; ?></td>
              <td><?php echo ($vo["info"]); ?></td>
              <td><?php echo ($vo["get"]); ?></td>
              <td align="center"><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
              <td align="center"><?php echo ($vo["ip"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> <?php echo ($Page); ?> </div>
      </div>
    </div>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js"></script>
</body>
</html>