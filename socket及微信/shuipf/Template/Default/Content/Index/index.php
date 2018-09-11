<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="baidu-site-verification" content="E9w6WQ9xWg" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
<meta name="description" content="{$SEO['description']}" />
<meta name="keywords" content="{$SEO['keyword']}" />
<link type="text/css" rel="stylesheet" href=".{$config_siteurl}statics/default/Style/base.css" />

</head>

<body>
	<!--  页面头部  -->
	<template file="Content/header.php"/>
	<!--  头部结束  -->
	<!--  内容区域  -->
    <div class="coner">
    	<!--  海报区域  --> 
    	<div class="hb">
            <div id="player">
                <ul class="Limg">
                <position action="position" posid="1" order="id asc">
                <volist name="data" id="vo">
                    <li><a href="javascript:void(0);"><img src="{$vo.data.thumb}"></a></li>
                </volist>
                </position>    
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
        	<a href="{:getCategory(7,'url')}"><span class="apply1 png_bg"></span></a>
            <a href="{:getCategory(8,'url')}"><span class="apply2 png_bg"></span></a>
            <a href="{:getCategory(9,'url')}"><span class="apply3 png_bg"></span></a>
            <a href="{:getCategory(10,'url')}"><span class="apply4 png_bg"></span></a>
            <a href="{:getCategory(11,'url')}"><span class="apply5 png_bg"></span></a>     
            <a href="{:getCategory(12,'url')}"><span class="apply6 png_bg"></span></a>
            <a href="{:getCategory(13,'url')}"><span class="apply7 png_bg"></span></a> 
        </div>
        <h4><br/><br/>科技引领高度，专注成就梦想<br/><br/></h4>
        <p>{:getCategory(2,'description')}</p>
        <a class="gd png_bg" href="{:getCategory(3,'url')}">了解更多</a>
        <div style=" width:100%; height:auto; background:#eaeaea">
        <div class="news" style="background:none;margin-bottom:0;" >
        	<div class="news_con">
            	<h3><a style="color:#666;text-decoration:none;" href="{:getCategory(19,'url')}">新闻中心</a> <i>/NEWS</i></h3>
                <div class="new_x">
                	<!-- <div style=" width:1050px;">
                	<position action="position" posid="5" order="id asc">
                	<volist name="data" id="vo">
                    <div class="new_a">
                    	<a href="{$vo.data.url}"><img src="{$vo.data.thumb}"/></a>
                        <h5><a href="{$vo.data.url}">{$vo.data.title}</a></h5>
                        <p>{$vo.data.description}</p>
                        <span>+</span>
                    </div>
                    </volist>
                    </position>
                    </div>-->
                    <div class="new_a">
                    <content action="lists" catid="19"  order="id DESC" num="1" page="$page">
                	<volist name="data" id="vo">
                    	<a href="{$vo.url}"><img src="{$vo.thumb}" width="314px" height="184"/></a>
                        <h5><a href="{$vo.url}">{$vo.title}</a></h5>
                        <p><b style="display:block;width:270px; height:96px; font-weight:normal; overflow:hidden;">{$vo.description|str_cut=###,80}</b><a href="{:getCategory(19,'url')}" style="display: block;width:60px;">[公司新闻]</a></p>
                        <span>+</span>
                    </volist>
                    </content>
                    </div>
                    <div class="new_a">
                    <content action="lists" catid="20"  order="id DESC" num="1" page="$page">
                	<volist name="data" id="vo">
                    	<a href="{$vo.url}"><img src="{$vo.thumb}" width="314px" height="184"/></a>
                        <h5><a href="{$vo.url}">{$vo.title}</a></h5>
                        <p><b style="display:block;width:270px; height:96px; font-weight:normal; overflow:hidden;">{$vo.description|str_cut=###,80}</b><a href="{:getCategory(20,'url')}" style="display: block;width:60px;">[行业资讯]</a></p>
                        <span>+</span>
                    </volist>
                    </content>
                    </div>
                    <div class="new_a last">
                    	<content action="lists" catid="21"  order="id DESC" num="1" page="$page">
	                	<volist name="data" id="vo">
	                    	<a href="{$vo.url}"><img src="{$vo.thumb}" width="314px" height="184"/></a>
	                        <h5><a href="{$vo.url}">{$vo.title}</a></h5>
	                        <p><b style="display:block;width:270px; height:96px; font-weight:normal; overflow:hidden;">{$vo.description|str_cut=###,80}</b><a href="{:getCategory(21,'url')}" style="display: block;width:60px;">[技术参考]</a></p>
	                        <span>+</span>
	                    </volist>
	                    </content>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- <div style=" width:100%; height:auto; background:#fff">
        <div class="news xct" style="background:none;">
        	<img src=".{$config_siteurl}statics/default/Images/xct.jpg" />
        </div> 
        </div>-->
        <div class="news" style="background: none;">
        	<div class="news_con">
            	<h3><a style="color:#666;text-decoration:none;" href="{:getCategory(2,'url')}">产品中心</a> <i>/PRODUCT</i></h3>
                <div class="cp">
                	<div style="width: 1050px;">
                	<position action="position" posid="2" order="id desc" num="8">
                	<volist name="data" id="vo">
                    <a href="{$vo.data.url}" class="cp_xx">
                    	<img src="{$vo.data.thumb}"/>
                        <span class="png_bg">{$vo.data.title}</span>
                    </a>
                    </volist>
					</position>    
					</div>                
                </div>
            </div>
        </div>
		<div class="news hzgj" style="background: none;">
        	<div class="news_con">
            	<h3><a style="color:#666;text-decoration:none;" href="{:getCategory(14,'url')}">合作结构</a> <i>/COOPERATION</i></h3>
                <div class="cp">
                	<div style=" width:1050px;">
                	<position action="position" posid="3" order="id desc" num="10">
                	<volist name="data" id="vo">
                    <div class="hz_xx">
                    	<a href="{$vo.data.url}"><img src="{$vo.data.thumb}"/></a>
                    </div>
                   	</volist>
                   	</position>
                   	</div>
                </div>
            </div>
        </div>
    </div>
	<!--  内容结束  --> 
	<!--  页面尾部  --> 
    <template file="Content/footer.php"/>
	<!--  尾部结束  --> 
    <!--[if IE 6]>
    <script src=".{$config_siteurl}statics/default/js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('.png_bg');
    </script>
    <![endif]-->
	<script type="text/javascript" src=".{$config_siteurl}statics/default/Js/jquery.js"></script>
    <script type="text/javascript" src=".{$config_siteurl}statics/default/Js/base.js"></script>   
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
