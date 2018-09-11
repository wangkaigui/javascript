<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ckplayer简单调用演示</title>
</head>
<body>
<div id="a1"></div>
<script type="text/javascript" src="/statics/default/ckplayer/ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript">
/*
	var flashvars={
		f:'http://img.ksbbs.com/asset/Mon_1605/0ec8cc80112a2d6.mp4',
		c:0,
		b:1,
		i:'http://www.ckplayer.com/static/images/cqdw.jpg'
		};
	*/	
	var flashvars={
		f:'/index.php?m=Index&a=tests&id=[$pat]',
		a:'1',
		s:1,
		c:0
	}

	//var video=['http://img.ksbbs.com/asset/Mon_1605/0ec8cc80112a2d6.mp4->video/mp4'];
	var video="<?php echo ($video); ?>";
	CKobject.embed('/statics/default/ckplayer/ckplayer/ckplayer.swf','a1','ckplayer_a1','600','400',false,flashvars,video);	
	
</script>
</body>
</html>