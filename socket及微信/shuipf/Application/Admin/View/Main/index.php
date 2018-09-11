<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body>
<div class="wrap1">
  <div id="home_toptip"></div>
  <h2 class="h_a">系统信息</h2>
  <div class="home_info">
    <ul>
      <volist name="server_info" id="vo">
        <li> <em>{$key}</em> <span>{$vo}</span> </li>
      </volist>
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
      <volist name="statistics" id="vo">
        <li> <em>{$key}:</em> <span><if condition="$vo neq null">{$vo}<else />0</if></span> </li>
      </volist>
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
<script src="{$config_siteurl}statics/js/common.js"></script> 
<script src="{$config_siteurl}statics/js/artDialog/artDialog.js"></script> 
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
	$.getJSON('{:U("Public/checkupdates")}',function(data){
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
	$.getJSON('{:U("public_license")}',function(data){
		if(data.name){$('#server_license').html(data.name);}else{$('#server_license').html('非授权用户');}
	});
	$.getJSON('{:U("public_latestversion")}',function(data){
		if(data.version){$('#server_version').html(data.version);$('#server_build').html(data.build);}
	});
	$.getJSON('{:U("public_notice")}',function(data){
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