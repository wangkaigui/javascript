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
   <div class="table_list">
   <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td width="10%">序号</td>
            <td width="10%" align="left" >用户名</td>
            <td width="10%" align="left" >所属角色</td>
            <td width="10%"  align="left" >最后登录IP</td>
            <td width="10%"  align="left" >最后登录时间</td>
            <td width="15%"  align="left" >E-mail</td>
            <td width="20%">备注</td>
            <td width="15%" align="center">管理操作</td>
          </tr>
        </thead>
        <tbody>
        <?php if(is_array($Userlist)): foreach($Userlist as $key=>$vo): ?><tr>
            <td width="10%" align="center"><?php echo ($vo["id"]); ?></td>
            <td width="10%" ><?php echo ($vo["username"]); ?></td>
            <td width="10%" ><?php echo D('Admin/Role')->getRoleIdName($vo['role_id'])?></td>
            <td width="10%" ><?php echo ($vo["last_login_ip"]); ?></td>
            <td width="10%"  >
            <?php if($vo['last_login_time'] == 0): ?>该用户还没登录过
            <?php else: ?>
            <?php echo (date("Y-m-d H:i:s",$vo["last_login_time"])); endif; ?>
            </td>
            <td width="15%"><?php echo ($vo["email"]); ?></td>
            <td width="20%"><?php echo ($vo["remark"]); ?></td>
            <td width="15%"  align="center">
            <?php if($User['username'] == $vo['username']): ?><font color="#cccccc">修改</font> | 
            <font color="#cccccc">删除</font>
            <?php else: ?>
            <a href="<?php echo U("Management/edit",array("id"=>$vo[id]));?>">修改</a> | 
            <a class="J_ajax_del" href="<?php echo U('Management/delete',array('id'=>$vo['id']));?>">删除</a><?php endif; ?>
            </td>
          </tr><?php endforeach; endif; ?>
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