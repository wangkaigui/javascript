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
   <form class="J_ajaxForm" action="<?php echo U('Management/adminadd');?>" method="post" id="myform">
   <div class="h_a">基本属性</div>
   <div class="table_full">
   <table width="100%" class="table_form contentWrap">
        <tbody>
          <tr>
            <th width="80">用户名</th>
            <td><input type="test" name="username" class="input" id="username">
              <span class="gray">请输入用户名</span></td>
          </tr>
          <tr>
            <th>密码</th>
            <td><input type="password" name="password" class="input" id="password" value="">
              <span class="gray">请输入密码</span></td>
          </tr>
          <tr>
            <th>确认密码</th>
            <td><input type="password" name="pwdconfirm" class="input" id="pwdconfirm" value="">
              <span class="gray">请输入确认密码</span></td>
          </tr>
          <tr>
            <th>E-mail</th>
            <td><input type="text" name="email" value="" class="input" id="email" size="30">
              <span class="gray">请输入E-mail</span></td>
          </tr>
          <tr>
            <th>真实姓名</th>
            <td><input type="text" name="nickname" value="" class="input" id="realname"></td>
          </tr>
          <tr>
          <th>备注</th>
          <td><textarea name="remark" rows="2" cols="20" id="remark" class="inputtext" style="height:100px;width:500px;"></textarea></td>
        </tr>
          <tr>
            <th>所属角色</th>
            <td><?php echo ($role); ?></td>
          </tr>
          <tr>
          <th>状态</td>
          <td><select name="status">
                <option value="1">开启</option>
                <option value="0" selected>禁止</option>
          </select></td>
        </tr>
        </tbody>
      </table>
   </div>
   <div class="btn_wrap">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
      </div>
    </div>
    </form>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js"></script>
</body>
</html>