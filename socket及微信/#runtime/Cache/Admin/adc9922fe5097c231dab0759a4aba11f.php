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
    .hiddens{display:none}
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
  
  <form action="<?php echo U('WxManage/createMenu');?>" method="post" >
    <div class="table_full">
      
	  
	  
		<table>
		   <tbody>
			   <tr>
				   <td>菜单标题</td>
				   <td><input type="text" id="title" style="width:250px;" name="title" placeholder="自定义菜单不超过16个字节"></td>
			   </tr>

			   <tr>
				   <td>菜单级别:</td>		
				   <td>
					   <input type="radio" value="0" id="zhu" name="pid"  checked />主菜单
					   <input type="radio"  id="er" name="pid" />二级菜单
				   </td>
			   </tr>


				 <tr class="hiddens" id="shanji">
					   <td>上级菜单</td>
					   <td>
						 <select name="pid"  >	
							   <option value="0">一级菜单</option>						  
							   <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						 </select>
					   </td>
				 </tr>


				 <tr>
					   <td>菜单类型:</td>
					   <td>
							<input type="radio" value="0" id="link" name="leixin" checked />链接跳转	
							<input type="radio" value="1" id="dianji" name="leixin" />内容回复			
					   </td> 
				 </tr>
				 <tr id="links">
					   <td for="url" >跳转链接</td>
					   <td><input type="text" id="url" name="url" placeholder="跳转链接"></td>
				 </tr>

				<tr id="keys" class='hiddens'>
					<td for="keys">关键词</td>
					   <td>
						<select name="keys" style="width:150px;">						
							   <?php if(is_array($keys)): $i = 0; $__LIST__ = $keys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["key"]); ?>"><?php echo ($vo["key"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						 </select>
					</td>
				</tr>

				<tr>
					   <td for="sorts">排序</td>
					   <td><input type="text" id="sorts" value="100" /></td>
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
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js"></script>
</body>
</html>

<script>
    $("#dianji").click(function(){
        $("#links").addClass("hiddens");
        $("#keys").removeClass("hiddens");
        });
        $("#link").click(function(){
            $("#links").removeClass("hiddens");
            $("#keys").addClass("hiddens");
        });
        $("#er").click(function(){
            $("#shanji").removeClass("hiddens");
        });
        $("#zhu").click(function(){
            $("#shanji").addClass("hiddens");
        });
	
	
		function ajaxGet(catid){
		$.ajax({
			type: "POST",
			url: "index.php?g=Admin&m=PatentManage&a=ajaxChange",
			dataType:'json',
			data: {
				'catid':catid,
			},
			success: function(data){	
				if (data.ret == 1) {
                    var d = data.data;
                    if (d != null && d != '') {
                        count = d.length;
                        var option = '<option value="">请选择</option>';
                        for (i = 0; i < count; i++) {
                            option += "<option value='" + d[i].catid + "'>" + d[i].catname + "</option>";
                        }
                        $("#serviceTypeId").html(option);
                        
                    } else {
                        $("#serviceTypeId").html('<option value="">暂无相关类</option>');
                    }
                }else {
                        $("#serviceTypeId").html('<option value="">暂无相关类</option>');
                    }	
			},
			error:function(){
				
			},
		});
	}
</script>