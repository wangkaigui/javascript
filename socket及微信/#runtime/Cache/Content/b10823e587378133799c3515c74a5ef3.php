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
  <table width="100%" cellspacing="0" >
    <thead>
      <tr>
        <td width="50" align="center">ModelID</td>
        <td width="100" align="center">模型名称</td>
        <td width="100" align="center">数据表</td>
        <td  align="center">描述</td>
        <td width="100" align="center">状态</td>
        <td width="230" align="center">管理操作</td>
      </tr>
    </thead>
    <tbody>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
        <td align='center'><?php echo ($vo["modelid"]); ?></td>
        <td align='center'><?php echo ($vo["name"]); ?></td>
        <td align='center'><?php echo ($vo["tablename"]); ?></td>
        <td align='center'><?php echo ($vo["description"]); ?></td>
        <td align='center'><font color="red"><?php if($vo['disabled'] == '1' ): ?>╳<?php else: ?>√<?php endif; ?></font></td>
        <td align='center'>
        <?php
 $operate = array(); if(\Libs\System\RBAC::authenticate('edit')){ $operate[] = '<a href="'.U("edit",array("modelid"=>$vo['modelid'])).'">修改</a>'; } if(\Libs\System\RBAC::authenticate('Field/index')){ $operate[] = '<a href="'.U("Field/index",array("modelid"=>$vo['modelid'])).'">字段管理</a>'; } if(\Libs\System\RBAC::authenticate('disabled')){ if($vo['disabled'] == 0){ $operate[] = '<a href="'.U("disabled",array("modelid"=>$vo['modelid'],"disabled"=>0)).'">禁用</a>'; }else{ $operate[] = '<a href="'.U("disabled",array("modelid"=>$vo['modelid'],"disabled"=>1)).'"><font color="#FF0000">启用</font></a>'; } } if(\Libs\System\RBAC::authenticate('delete')){ $operate[] = '<a class="J_ajax_del" href="'.U("delete",array("modelid"=>$vo['modelid'])).'">删除</a>'; } if(\Libs\System\RBAC::authenticate('export')){ $operate[] = '<a href="'.U("export",array("modelid"=>$vo['modelid'])).'">导出模型</a>'; } echo implode(' | ',$operate); ?>
        </td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
  </div>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js?v"></script>
<script type="text/javascript">

</script>
</body>
</html>