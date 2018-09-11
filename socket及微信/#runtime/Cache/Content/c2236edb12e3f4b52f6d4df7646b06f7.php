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
  <div class="nav">
    <ul class="cc">
      <li <?php if( !isset($_GET['status']) ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Content/classlist', array('catid'=>$catid) );?>"><?php echo ($catname); ?>列表</a></li>
      <li <?php if( isset($_GET['status']) ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Content/classlist', array('catid'=>$catid ,'search'=>1 ,'status'=>1) );?>">待审核文章</a></li>
    </ul>
  </div>
  <div class="mb10">
		<a href="javascript:void(0)" onClick="javascript:openwinx('<?php echo U("Content/add",array("catid"=>$catid));?>','')" class="btn" title="添加内容"><span class="add"></span>添加内容</a>
         栏目列表生成：<select class="select_2" onChange="window.location.href=''+this.value+''">
       <option value="<?php echo U('Createhtml/categoryhtml',array('catid'=>$catid));?>" >列表生成</option>
       <option value="<?php echo U('Createhtml/categoryhtml',array('catid'=>$catid));?>">生成当前栏目列表</option>
       <?php if( $parentid ): ?><option value="<?php echo U('Createhtml/categoryhtml',array('catid'=>$parentid));?>">生成父栏目列表</option><?php endif; ?>
    </select>
    <a href="<?php echo ($url); ?>" target="_blank"  class="btn" title="访问该栏目">访问该栏目</a>
  </div>
  <div class="h_a">搜索</div>
  <form method="post" action="<?php echo U('classlist',array('catid'=>$catid));?>">
  <input type="hidden" value="<?php echo ($catid); ?>" name="catid">
  <input type="hidden" value="0" name="steps">
  <input type="hidden" value="1" name="search">
    <div class="search_type cc mb10">
      <div class="mb10"> 
        <span class="mr20">时间：
        <input type="text" name="start_time" class="input length_2 J_date" value="<?php echo ($_GET['start_time']); ?>" style="width:80px;">-<input type="text" class="input length_2 J_date" name="end_time" value="<?php echo ($_GET['end_time']); ?>" style="width:80px;">
        <select class="select_2" name="posids"style="width:70px;">
          <option value='' <?php if( $posids == '' ): ?>selected<?php endif; ?>>全部</option>
          <option value="1" <?php if( $posids == 1 ): ?>selected<?php endif; ?>>推荐</option>
          <option value="2" <?php if( $posids == 2 ): ?>selected<?php endif; ?>>不推荐</option>
        </select>
        <select class="select_2" name="searchtype" style="width:70px;">
          <option value='0' <?php if( $searchtype == '0' ): ?>selected<?php endif; ?>>标题</option>
          <option value='1' <?php if( $searchtype == '1' ): ?>selected<?php endif; ?>>简介</option>
          <option value='2' <?php if( $searchtype == '2' ): ?>selected<?php endif; ?>>用户名</option>
          <option value='3' <?php if( $searchtype == '3' ): ?>selected<?php endif; ?>>ID</option>
        </select>
        关键字：
        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="<?php echo ($_GET["keyword"]); ?>" placeholder="请输入关键字...">
        <button class="btn">搜索</button>
        </span>
      </div>
    </div>
  </form>
  <form class="J_ajaxForm" action="" method="post">
    <div class="table_list">
      <table width="100%">
        <colgroup>
        <col width="16">
        <col width="50">
        <col width="60">
        <col width="">
        <col width="80">
        <col width="90">
        <col width="140">
        <col width="120">
        </colgroup>
        <thead>
          <tr>
            <td><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
            <td>排序</td>
            <td align="center">ID</td>
            <td>标题</td>
            <td align="center">点击量</td>
            <td align="center">发布人</td>
            <td align="center"><span>发帖时间</span></td>
            <td align="center">管理操作</td>
          </tr>
        </thead>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>"></td>
            <td><input name='listorders[<?php echo ($vo["id"]); ?>]' class="input mr5"  type='text' size='3' value='<?php echo ($vo["listorder"]); ?>'></td>
            <td align="center"><a href="<?php echo U("Createhtml/batch_show", array("catid"=>$vo['catid'] ,"steps"=>"0" ,"ids"=>$vo['id']) );?>" title="点击生成"><?php echo ($vo["id"]); ?></a></td>
            <td><?php if( $vo['status']==99 ): ?><a href="<?php echo ($vo["url"]); ?>" target="_blank"><span style="" ><?php echo ($vo["title"]); ?></span></a>
                <?php else: ?>
                <a href="<?php echo U('public_preview',array('catid'=>$vo['catid'],'id'=>$vo['id']) );?>" target="_blank"><font color="#FF0000">[未审核]</font> - <?php echo ($vo["title"]); ?></a><?php endif; ?>
              <?php if( $vo['thumb']!='' ): ?><img src="<?php echo ($config_siteurl); ?>statics/images/icon/small_img.gif" title="标题图片"><?php endif; ?>
              <?php if( $vo['posid'] ): ?><img src="<?php echo ($config_siteurl); ?>statics/images/icon/small_elite.gif" title="推荐位"><?php endif; ?>
              <?php if( $vo['islink'] ): ?><img src="<?php echo ($config_siteurl); ?>statics/images/icon/link.png" title="转向地址"><?php endif; ?></td>
            <td align="center"><?php echo ($vo["views"]); ?></td>
            <td align="center"><?php if( $vo['sysadd'] ): echo ($vo["username"]); ?>
                <?php else: ?>
                <font color="#FF0000"><?php echo ($vo["username"]); ?></font><img src="<?php echo ($config_siteurl); ?>statics/images/icon/contribute.png" title="会员投稿"><?php endif; ?></td>
            <td align="center"><?php echo (date("Y-m-d H:i:s",$vo["updatetime"])); ?></td>
            <td align="center">
            <?php
 $op = array(); $op[] = '<a href="javascript:;;" onClick="javascript:openwinx(\''.U("Content/edit",array("catid"=>$vo['catid'],"id"=>$vo['id'])).'\',\'\')">修改</a>'; $op[] = '<a href="'.U("Content/delete",array("catid"=>$vo['catid'],"id"=>$vo['id'])).'" class="J_ajax_del" >删除</a>'; if(isModuleInstall('Comments')){ $op[] = '<a href="'.U('Comments/Comments/index',array('searchtype'=>2,'keyword'=>'c-'.$vo['catid'].'-'.$vo['id'].'')).'" target="_blank">评论</a>'; } echo implode(' | ',$op); ?>
            </td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </table>
      <div class="p10"><div class="pages"> <?php echo ($Page); ?> </div> </div>
     
    </div>
    <div class="btn_wrap">
      <div class="btn_wrap_pd">
        <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>                
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo U('Content/listorder',array('catid'=>$catid));?>">排序</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo U('Content/public_check',array('catid'=>$catid));?>">审核</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo U('Content/public_nocheck',array('catid'=>$catid));?>">取消审核</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo U('Content/delete',array('catid'=>$catid));?>">删除</button>
        <button class="btn" type="button" onClick="pushs()">推送</button>
        <button class="btn" type="button" id="J_Content_remove">批量移动</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo U('Createhtml/batch_show',array('catid'=>$catid,'steps'=>0));?>">批量生成HTML</button>
      </div>
    </div>
  </form>
</div>
<script src="<?php echo ($config_siteurl); ?>statics/js/common.js?v"></script>
<script>
setCookie('refersh_time', 0);
function refersh_window() {
    var refersh_time = getCookie('refersh_time');
    if (refersh_time == 1) {
        window.location.reload();
    }
}
setInterval(function(){
	refersh_window()
}, 3000);
$(function () {
    Wind.use('ajaxForm','artDialog','iframeTools', function () {
        //批量移动
        $('#J_Content_remove').click(function (e) {
            var str = 0;
            var id = tag = '';
            $("input[name='ids[]']").each(function () {
                if ($(this).attr('checked')) {
                    str = 1;
                    id += tag + $(this).val();
                    tag = '|';
                }
            });
            if (str == 0) {
				art.dialog.through({
					id:'error',
					icon: 'error',
					content: '您没有勾选信息，无法进行操作！',
					cancelVal: '关闭',
					cancel: true
				});
                return false;
            }
            var $this = $(this);
            art.dialog.open("<?php echo ($config_siteurl); ?>index.php?g=Content&m=Content&a=remove&catid=<?php echo ($catid); ?>&ids=" + id, {
                title: "批量移动"
            });
        });
    });
});

function view_comment(obj) {
	Wind.use('artDialog','iframeTools', function () {
         art.dialog.open($(obj).attr("data-url"), {
			close:function(){
				$(obj).focus();
			},
            title: $(obj).attr("data-title"),
			width:"800px",
            height: '520px',
			id:"view_comment",
            lock: true,
            background:"#CCCCCC",
            opacity:0
        });
    });
}

function pushs() {
    $("form").submit(function () {
        return false;
    });
    var str = 0;
    var id = tag = '';
    $("input[name='ids[]']").each(function () {
        if ($(this).attr('checked')) {
            str = 1;
            id += tag + $(this).val();
            tag = '|';
        }
    });
    if (str == 0) {
       art.dialog({
		   id:'error',
		   icon: 'error',
		   content: '您没有勾选信息，无法进行操作！',
		   cancelVal: '关闭',
		   cancel: true
		});
        return false;
    }
    Wind.use('artDialog','iframeTools', function () {
         art.dialog.open("<?php echo ($config_siteurl); ?>index.php?g=Content&m=Content&a=push&action=position_list&modelid=<?php echo ($modelid); ?>&catid=<?php echo ($catid); ?>&id=" + id, {
            title: "信息推送"
        });
    });
}
</script>
</body>
</html>