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
<body>
<div class="wrap1">
  <div id="home_toptip"></div>
  <h2 class="h_a">系统信息</h2>
  <div class="home_info">
    <ul>
      <?php if(is_array($server_info)): $i = 0; $__LIST__ = $server_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li> <em><?php echo ($key); ?></em> <span><?php echo ($vo); ?></span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
</div>
<div class="wrap1">
  <div id="home_toptip"></div>
  <h2 class="h_a">天气预报</h2>
  <div class="home_info">
  <iframe name="weather_inc" src="http://i.tianqi.com/index.php?c=code&id=55" style="border:solid 0px #7ec8ea" width="255" height="294" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
  </div>
</div>
<div class="wrap1">
  <div id="home_toptip"></div>
  <h2 class="h_a">内容统计</h2>
  <div class="home_info">
    <ul>
      <?php if(is_array($statistics)): $i = 0; $__LIST__ = $statistics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li> <em><?php echo ($key); ?>:</em> <span><?php if($vo != null): echo ($vo); else: ?>0<?php endif; ?></span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
</div>
<div class="wrap1">
  <div id="home_toptip"></div>
  <h2 class="h_a">金百瑞公告</h2>
  <div class="home_info">
    <ul>
      <li>暂无信息</li>
    </ul>
  </div>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js"></script> 
<script src="<?php echo ($config_siteurl); ?>statics/js/artDialog/artDialog.js"></script> 
<script>
$("#btn_submit").click(function(){
	$("#tips_success").fadeTo(500,1);
});
artDialog.notice = function (options) {
    var opt = options || {},
        api, aConfig, hide, wrap, top,
        duration = 800;
        
    var config = {
        id: 'Notice',
        left: '100%',
        top: '100%',
        fixed: true,
        drag: false,
        resize: false,
        follow: null,
        lock: false,
        init: function(here){
            api = this;
            aConfig = api.config;
            wrap = api.DOM.wrap;
            top = parseInt(wrap[0].style.top);
            hide = top + wrap[0].offsetHeight;
            
            wrap.css('top', hide + 'px')
                .animate({top: top + 'px'}, duration, function () {
                    opt.init && opt.init.call(api, here);
                });
        },
        close: function(here){
            wrap.animate({top: hide + 'px'}, duration, function () {
                opt.close && opt.close.call(this, here);
                aConfig.close = $.noop;
                api.close();
            });
            
            return false;
        }
    };	
    
    for (var i in opt) {
        if (config[i] === undefined) config[i] = opt[i];
    };
    
    return artDialog(config);
};
/* 
$(function(){
	$.getJSON('<?php echo U("Public/checkupdates");?>',function(data){
		if(data.status){
			art.dialog({
				title:'升级提示',
				 icon: 'warning',
				content: '系统检测到新版本发布，请尽快更新到 '+data.version + '，以确保网站安全！',
				cancelVal: '关闭',
				cancel: true //为true等价于function(){}
			});
		}
	});
	$.getJSON('<?php echo U("public_license");?>',function(data){
		if(data.name){$('#server_license').html(data.name);}else{$('#server_license').html('非授权用户');}
	});
	$.getJSON('<?php echo U("public_latestversion");?>',function(data){
		if(data.version){$('#server_version').html(data.version);$('#server_build').html(data.build);}
	});
	$.getJSON('<?php echo U("public_notice");?>',function(data){
		if(data.title){
			art.dialog.notice({
				title: data.title,
				width: 400,// 必须指定一个像素宽度值或者百分比，否则浏览器窗口改变可能导致artDialog收缩
				content: data.content,
				close:function(){
					setCookie('notice_'+data.id,1,30);
				}
			});
		}
	});
}); 
*/
</script>
</body>
</html>