<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="span9 page_message">
    <section id="contents"> <include file="Addons/_nav" />
        <div class="wrap">
    	<div class="content">
    	<h5>在微信营销——公众号管理中<a name="member_pubic_set"></a></h5>
 
        <p>1.点击进入<a href="https://mp.weixin.qq.com" target="_blank">微信公众平台</a>并进入公众号信息页面</p>
        <p><img src="{$config_siteurl}statics/images/wx/help01.png" ></p>
        <p>2.在WeiPHP里增加公众号, 需要填写的信息来源如下图所示。图中右边是增加公众号的表单，左边是上一步打开的公众号信息页面</p>
        <DIV> <IMG src="{$config_siteurl}statics/images/wx/help02.jpg" ></DIV>
        <p>&nbsp;</p>
        <h5>微信接口配置<a name="weixin_set"></a></h5>
        <p>1.先从这里公众号管理列表里进入接口配置</p>
        <DIV> <IMG src="{$config_siteurl}statics/images/wx/help04.jpg" ></DIV>
        
        <p>&nbsp;</p>
        <p>2.以下是你的公众号的配置信息<br>
          你的接口URL是：<span style="color: #FF0000">
		  <?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/Weixin/index"; ?></span><br>
          Token值是：<span style="color: #F00">{$lists['token']}</span></p>
        <p>在多个公众号的情况下，系统是以微信的原始ID来区分各个公众号的数据归属，用户只需要在增加公众号是确保原始ID填写正确就行，不需要担心多个公众号如何区分的问题。</p>
        <p>3. 在微信公众管理平台里进入开发模式，并把开发模型开启，开启后成为开发者，接着配置URL和Token,这两个值就是上面标红的内容</p>
        <!--<p><img src="{:SITE_URL}/Public/Home/images/help03.png" ></p>-->
        <p>至此配置完毕，如果配置过程中有问题，可查看<a href="http://mp.weixin.qq.com/wiki/index.php?title=%E6%8E%A5%E5%85%A5%E6%8C%87%E5%8D%97" target="_blank">微信的说明文档</a></p>
   	  </div>
    </div>
    </section>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>