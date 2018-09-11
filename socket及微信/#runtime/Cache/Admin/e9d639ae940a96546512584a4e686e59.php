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
<div class="wrap jj">
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
  <div class="common-form">
    <form method="post" class="J_ajaxForm" action="<?php echo U('Menu/add');?>">
      <div class="h_a">菜单信息</div>
      <div class="table_list">
        <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
          <tbody>
            <tr>
              <td width="140">上级:</td>
              <td><select name="parentid">
                  <option value="0">作为一级菜单</option>
                     <?php echo ($select_categorys); ?>
                </select></td>
            </tr>
            <tr>
              <td>名称:</td>
              <td><input type="text" class="input" name="name" value=""></td>
            </tr>
            <tr>
              <td>模块:</td>
              <td><input type="text" class="input" name="app" id="app" value="Admin"></td>
            </tr>
            <tr>
              <td>控制器:</td>
              <td><input type="text" class="input" name="controller" id="controller" value=""></td>
            </tr>
            <tr>
              <td>方法:</td>
              <td><input type="text" class="input" name="action" id="action" value=""></td>
            </tr>
            <tr>
              <td>参数:</td>
              <td><input type="text" class="input length_5" name="parameter" value="">
                例:groupid=1&amp;type=2</td>
            </tr>
            <tr>
              <td>备注:</td>
              <td><textarea name="remark" rows="5" cols="57"><?php echo ($remark); ?></textarea></td>
            </tr>
            <tr>
              <td>状态:</td>
              <td><select name="status">
                  <option value="1" <?php if(($status) == "1"): ?>selected<?php endif; ?>>显示</option>
                  <option value="0" <?php if(($status) == "0"): ?>selected<?php endif; ?>>不显示</option>
                </select>需要明显不确定的操作时建议设置为不显示，例如：删除，修改等</td>
            </tr>
            <tr>
              <td>类型:</td>
              <td><select name="type">
                  <option value="1" selected>权限认证+菜单</option>
                  <option value="0" >只作为菜单</option>
                </select>
                注意：“权限认证+菜单”表示加入后台权限管理，纯粹是菜单项请不要选择此项。</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="">
        <div class="btn_wrap_pd">
          <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js"></script>
</body>
</html>