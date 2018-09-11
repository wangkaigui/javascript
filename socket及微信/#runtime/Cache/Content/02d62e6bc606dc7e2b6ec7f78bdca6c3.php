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
  <div class="h_a">温馨提示</div>
  <div class="prompt_text">
    <p>如果您已经修改模型字段管理中“<font color="#FF0000">在推荐位标签中调用</font>”这个选项，可以使用“<font color="#FF0000">数据重建</font>”功能进行数据重建！</p>
  </div>
  <div class="table_list">
    <table width="100%" cellspacing="0">
      <thead>
        <tr>
          <td width="50">排序</td>
          <td width="20"  align="center">ID</td>
          <td>推荐位名称</td>
          <td width="50" align="center">所属栏目</td>
          <td width="50" align="center">所属模型</td>
          <td width="180" align="center">管理操作</td>
        </tr>
      </thead>
      <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><input name='listorders[<?php echo ($vo["posid"]); ?>]' type='text' size='2' value='<?php echo ($vo["listorder"]); ?>' class="input"></td>
            <td align="center"><?php echo ($vo["posid"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td align="center">
            <?php if( empty($vo['catid']) ): ?><font color="#FF0000">无限制</font>
            <?php else: ?>
            多栏目<?php endif; ?>
            </td>
            <td align="center">
            <?php if( empty($vo['modelid']) ): ?><font color="#FF0000">无限制</font>
            <?php else: ?>
            多模型<?php endif; ?>
            </td>
            <td align="center">
            <?php
 $op = array(); if(\Libs\System\RBAC::authenticate('item')){ $op[] = '<a href="'.U('Position/item',array('posid'=>$vo['posid'])).'">信息管理</a>'; } if(\Libs\System\RBAC::authenticate('rebuilding')){ $op[] = '<a href="'.U('Position/rebuilding',array('posid'=>$vo['posid'])).'">数据重建</a>'; } if(\Libs\System\RBAC::authenticate('edit')){ $op[] = '<a href="'.U('Position/edit',array('posid'=>$vo['posid'])).'">修改</a>'; } if(\Libs\System\RBAC::authenticate('delete')){ $op[] = '<a class="J_ajax_del" href="'.U('Position/delete',array('posid'=>$vo['posid'])).'">删除</a>'; } echo implode(" | ",$op); ?>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
  </div>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js?v"></script>
</body>
</html>