<?php if (!defined('THINK_PATH')) exit();?>﻿<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="baidu-site-verification" content="E9w6WQ9xWg" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php if( isset($SEO['title']) && !empty($SEO['title']) ): echo ($SEO['title']); endif; echo ($SEO['site_title']); ?></title>
<meta name="description" content="<?php echo ($SEO['description']); ?>" />
<meta name="keywords" content="<?php echo ($SEO['keyword']); ?>" />
<link type="text/css" rel="stylesheet" href=".<?php echo ($config_siteurl); ?>statics/default/Style/base.css" />

</head>

<body>
	<!--  页面头部  -->
	﻿<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
    <div class="header">
    	<div class="Box  topBox">
			<a class="logo" href="index.php"><img  class="png_bg" src=".<?php echo ($config_siteurl); ?>statics/default/Images/logo.png" /></a>
            <div class="menu">
            	<a class="<?php if($catid == null): ?>focus<?php endif; ?>" href="index.php">首页</a>
                <a class="<?php if($catid == 3): ?>focus<?php endif; ?>" href="<?php echo getcategory('3',url);?>">关于我们</a>
                <a class="<?php if($catid == 6): ?>focus<?php endif; ?>" href="<?php echo getcategory('6',url);?>">产品展示</a>
                <a class="<?php if($catid == 14): ?>focus<?php endif; ?>" href="<?php echo getcategory('14',url);?>">客户案例</a>
                <a class="<?php if($catid == 16): ?>focus<?php endif; ?>" href="<?php echo getcategory('16',url);?>">联系我们</a>
                <a class="<?php if($catid == 17): ?>focus<?php endif; ?>" href="<?php echo getcategory('17',url);?>">人才招聘</a>
            </div>
        </div>
    </div>
    <div class="qh" style=" position:fixed; right:0; top:0; width:100px; height:30px;">
	<a href="http://www.whglyq.com/" style="display:block; width:45px; height:30px; text-align:center; line-height:30px; float:left; color:#000;">中文版</a>
	<span style="display:block; width:10px; height:30px;float:left; text-align:center; line-height:30px; color:#000;">|</span><a href="http://www.whglyq.com/en" style="display:block; width:45px; height:30px;float:left; text-align:center; line-height:30px; color:#000;">English</a></div>
	<!--  头部结束  -->
	<!--  内容区域  -->
    <div class="coner">
    	<!--  海报区域  --> 
    	<div class="hb">
            <div id="player">
                <ul class="Limg">
                <?php $Position_tag = \Think\Think::instance("\Content\TagLib\Position"); if(method_exists($Position_tag, "position")){ $data = $Position_tag->position(array('action'=>'position','posid'=>'1','order'=>'id asc',)); }; if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="javascript:void(0);"><img src="<?php echo ($vo["data"]["thumb"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>    
                </ul>
                <em class="Nubbt">
                    <span class="on" class="">1</span>
                    <span>2</span>
                    <span>3</span>
                    <span>4</span>
                    </em> 
            </div>
        </div>
 		<!--  海报结束  --> 
        <h3><br/>应用领域<br/><br/></h3>
        <div class="apply">
        	<a href="<?php echo getCategory(7,'url');?>"><span class="apply1 png_bg"></span></a>
            <a href="<?php echo getCategory(8,'url');?>"><span class="apply2 png_bg"></span></a>
            <a href="<?php echo getCategory(9,'url');?>"><span class="apply3 png_bg"></span></a>
            <a href="<?php echo getCategory(10,'url');?>"><span class="apply4 png_bg"></span></a>
            <a href="<?php echo getCategory(11,'url');?>"><span class="apply5 png_bg"></span></a>     
            <a href="<?php echo getCategory(12,'url');?>"><span class="apply6 png_bg"></span></a>
            <a href="<?php echo getCategory(13,'url');?>"><span class="apply7 png_bg"></span></a> 
        </div>
        <h4><br/><br/>科技引领高度，专注成就梦想<br/><br/></h4>
        <p><?php echo getCategory(2,'description');?></p>
        <a class="gd png_bg" href="<?php echo getCategory(3,'url');?>">了解更多</a>
        <div style=" width:100%; height:auto; background:#eaeaea">
        <div class="news" style="background:none;margin-bottom:0;" >
        	<div class="news_con">
            	<h3><a style="color:#666;text-decoration:none;" href="<?php echo getCategory(19,'url');?>">新闻中心</a> <i>/NEWS</i></h3>
                <div class="new_x">
                	<!-- <div style=" width:1050px;">
                	<?php $Position_tag = \Think\Think::instance("\Content\TagLib\Position"); if(method_exists($Position_tag, "position")){ $data = $Position_tag->position(array('action'=>'position','posid'=>'5','order'=>'id asc',)); }; if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="new_a">
                    	<a href="<?php echo ($vo["data"]["url"]); ?>"><img src="<?php echo ($vo["data"]["thumb"]); ?>"/></a>
                        <h5><a href="<?php echo ($vo["data"]["url"]); ?>"><?php echo ($vo["data"]["title"]); ?></a></h5>
                        <p><?php echo ($vo["data"]["description"]); ?></p>
                        <span>+</span>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>-->
                    <div class="new_a">
                    <?php $content_tag = \Think\Think::instance("\Content\TagLib\Content"); $count = $content_tag->count(array('action'=>'lists','catid'=>'19','order'=>'id DESC','num'=>'1','page'=>$page,'pagefun'=>'page','return'=>'data',)); $_page_ = page($count ,1,$page,array('isrule'=>'1',)); $GLOBALS["Total_Pages"] = $_page_->Total_Pages; $pages = $_page_->show("default"); $pagetotal = $_page_->Total_Pages; $totalsize = $_page_->Total_Size; if(method_exists($content_tag, "lists")){ $data = $content_tag->lists(array('action'=>'lists','catid'=>'19','order'=>'id DESC','num'=>'1','page'=>$page,'pagefun'=>'page','return'=>'data','count'=>$count,'limit'=>$_page_->firstRow.",".$_page_->listRows,)); } if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["url"]); ?>"><img src="<?php echo ($vo["thumb"]); ?>" width="314px" height="184"/></a>
                        <h5><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?></a></h5>
                        <p><b style="display:block;width:270px; height:96px; font-weight:normal; overflow:hidden;"><?php echo (str_cut($vo["description"],80)); ?></b><a href="<?php echo getCategory(19,'url');?>" style="display: block;width:60px;">[公司新闻]</a></p>
                        <span>+</span><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="new_a">
                    <?php $content_tag = \Think\Think::instance("\Content\TagLib\Content"); $count = $content_tag->count(array('action'=>'lists','catid'=>'20','order'=>'id DESC','num'=>'1','page'=>$page,'pagefun'=>'page','return'=>'data',)); $_page_ = page($count ,1,$page,array('isrule'=>'1',)); $GLOBALS["Total_Pages"] = $_page_->Total_Pages; $pages = $_page_->show("default"); $pagetotal = $_page_->Total_Pages; $totalsize = $_page_->Total_Size; if(method_exists($content_tag, "lists")){ $data = $content_tag->lists(array('action'=>'lists','catid'=>'20','order'=>'id DESC','num'=>'1','page'=>$page,'pagefun'=>'page','return'=>'data','count'=>$count,'limit'=>$_page_->firstRow.",".$_page_->listRows,)); } if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["url"]); ?>"><img src="<?php echo ($vo["thumb"]); ?>" width="314px" height="184"/></a>
                        <h5><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?></a></h5>
                        <p><b style="display:block;width:270px; height:96px; font-weight:normal; overflow:hidden;"><?php echo (str_cut($vo["description"],80)); ?></b><a href="<?php echo getCategory(20,'url');?>" style="display: block;width:60px;">[行业资讯]</a></p>
                        <span>+</span><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="new_a last">
                    	<?php $content_tag = \Think\Think::instance("\Content\TagLib\Content"); $count = $content_tag->count(array('action'=>'lists','catid'=>'21','order'=>'id DESC','num'=>'1','page'=>$page,'pagefun'=>'page','return'=>'data',)); $_page_ = page($count ,1,$page,array('isrule'=>'1',)); $GLOBALS["Total_Pages"] = $_page_->Total_Pages; $pages = $_page_->show("default"); $pagetotal = $_page_->Total_Pages; $totalsize = $_page_->Total_Size; if(method_exists($content_tag, "lists")){ $data = $content_tag->lists(array('action'=>'lists','catid'=>'21','order'=>'id DESC','num'=>'1','page'=>$page,'pagefun'=>'page','return'=>'data','count'=>$count,'limit'=>$_page_->firstRow.",".$_page_->listRows,)); } if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["url"]); ?>"><img src="<?php echo ($vo["thumb"]); ?>" width="314px" height="184"/></a>
	                        <h5><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?></a></h5>
	                        <p><b style="display:block;width:270px; height:96px; font-weight:normal; overflow:hidden;"><?php echo (str_cut($vo["description"],80)); ?></b><a href="<?php echo getCategory(21,'url');?>" style="display: block;width:60px;">[技术参考]</a></p>
	                        <span>+</span><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- <div style=" width:100%; height:auto; background:#fff">
        <div class="news xct" style="background:none;">
        	<img src=".<?php echo ($config_siteurl); ?>statics/default/Images/xct.jpg" />
        </div> 
        </div>-->
        <div class="news" style="background: none;">
        	<div class="news_con">
            	<h3><a style="color:#666;text-decoration:none;" href="<?php echo getCategory(2,'url');?>">产品中心</a> <i>/PRODUCT</i></h3>
                <div class="cp">
                	<div style="width: 1050px;">
                	<?php $Position_tag = \Think\Think::instance("\Content\TagLib\Position"); if(method_exists($Position_tag, "position")){ $data = $Position_tag->position(array('action'=>'position','posid'=>'2','order'=>'id desc','num'=>'8',)); }; if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["data"]["url"]); ?>" class="cp_xx">
                    	<img src="<?php echo ($vo["data"]["thumb"]); ?>"/>
                        <span class="png_bg"><?php echo ($vo["data"]["title"]); ?></span>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>    
					</div>                
                </div>
            </div>
        </div>
		<div class="news hzgj" style="background: none;">
        	<div class="news_con">
            	<h3><a style="color:#666;text-decoration:none;" href="<?php echo getCategory(14,'url');?>">合作结构</a> <i>/COOPERATION</i></h3>
                <div class="cp">
                	<div style=" width:1050px;">
                	<?php $Position_tag = \Think\Think::instance("\Content\TagLib\Position"); if(method_exists($Position_tag, "position")){ $data = $Position_tag->position(array('action'=>'position','posid'=>'3','order'=>'id desc','num'=>'10',)); }; if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hz_xx">
                    	<a href="<?php echo ($vo["data"]["url"]); ?>"><img src="<?php echo ($vo["data"]["thumb"]); ?>"/></a>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                   	</div>
                </div>
            </div>
        </div>
    </div>
	<!--  内容结束  --> 
	<!--  页面尾部  --> 
    
	<!--  尾部结束  --> 
    <!--[if IE 6]>
    <script src=".<?php echo ($config_siteurl); ?>statics/default/js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('.png_bg');
    </script>
    <![endif]-->
	<script type="text/javascript" src=".<?php echo ($config_siteurl); ?>statics/default/Js/jquery.js"></script>
    <script type="text/javascript" src=".<?php echo ($config_siteurl); ?>statics/default/Js/base.js"></script>   
	<script type="text/javascript">
    //*焦点切换
    (function(){
        if(!Function.prototype.bind){
            Function.prototype.bind = function(obj){
                var owner = this,args = Array.prototype.slice.call(arguments),callobj = Array.prototype.shift.call(args);
                return function(e){e=e||top.window.event||window.event;owner.apply(callobj,args.concat([e]));};
            };
        }
    })();
    var player = function(id){
        this.ctn = document.getElementById(id);
        this.adLis = null;
        this.btns = null;
        this.animStep = 0.2;//动画速度0.1～0.9
        this.switchSpeed = 3;//自动播放间隔(s)
        this.defOpacity = 1;
        this.tmpOpacity = 1;
        this.crtIndex = 0;
        this.crtLi = null;
        this.adLength = 0;
        this.timerAnim = null;
        this.timerSwitch = null;
        this.init();
    };
    player.prototype = {
        fnAnim:function(toIndex){
            if(this.timerAnim){window.clearTimeout(this.timerAnim);}
            if(this.tmpOpacity <= 0){
                this.crtLi.style.opacity = this.tmpOpacity = this.defOpacity;
                this.crtLi.style.filter = 'Alpha(Opacity=' + this.defOpacity*100 + ')';
                this.crtLi.style.zIndex = 0;
                this.crtIndex = toIndex;
                return;
            }
            this.crtLi.style.opacity = this.tmpOpacity = this.tmpOpacity - this.animStep;
            this.crtLi.style.filter = 'Alpha(Opacity=' + this.tmpOpacity*100 + ')';
            this.timerAnim = window.setTimeout(this.fnAnim.bind(this,toIndex),50);
        },
        fnNextIndex:function(){
            return (this.crtIndex >= this.adLength-1)?0:this.crtIndex+1;
        },
        fnSwitch:function(toIndex){
            if(this.crtIndex==toIndex){return;}
            this.crtLi = this.adLis[this.crtIndex];
            for(var i=0;i<this.adLength;i++){
                this.adLis[i].style.zIndex = 0;
            }
            this.crtLi.style.zIndex = 2;
            this.adLis[toIndex].style.zIndex = 1;
            for(var i=0;i<this.adLength;i++){
                this.btns[i].className = '';
            }
            this.btns[toIndex].className = 'on'
            this.fnAnim(toIndex);
        },
        fnAutoPlay:function(){
            this.fnSwitch(this.fnNextIndex());
        },
        fnPlay:function(){
            this.timerSwitch = window.setInterval(this.fnAutoPlay.bind(this),this.switchSpeed*1000);
        },
        fnStopPlay:function(){
            window.clearTimeout(this.timerSwitch);
        },
        init:function(){
            this.adLis = this.ctn.getElementsByTagName('li');
            this.btns = this.ctn.getElementsByTagName('em')[0].getElementsByTagName('span');
            this.adLength = this.adLis.length;
            for(var i=0,l=this.btns.length;i<l;i++){
                with({i:i}){
                    this.btns[i].index = i;
                    this.btns[i].onclick = this.fnSwitch.bind(this,i);
                    this.btns[i].onclick = this.fnSwitch.bind(this,i);
                }
            }
            this.adLis[this.crtIndex].style.zIndex = 2;
            this.fnPlay();
            this.ctn.onmouseover = this.fnStopPlay.bind(this);
            this.ctn.onmouseout = this.fnPlay.bind(this);
        }
    };
    var player1 = new player('player');
    </script> <!--/*焦点图切换JS结束*/--> 
</body>
</html>