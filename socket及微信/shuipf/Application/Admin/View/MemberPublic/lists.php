<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form name="myform" class="J_ajaxForm" action="{:U('delete')}" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td width="6%"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">全选</td>
            <td align="center" width="15%">公众号名称</td>
            <td align="center" width="15%">公众号头像</td>
            <td align="center" width="25%">Token</td>
            <td align="center" width="10%">当前公众号</td>
            <td align="center" width="25%">相关操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="wplist" id="vo">
          <tr>
            <td width="50"><input type="checkbox" value="{$vo.tagid}" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="tagid[]">
			<input type="hidden" mid="{$vo.id}">
			{$vo.id}
			</td>
            <td align="center">{$vo.public_name}</td>
			<td align="center">{$vo.headface_url}</td>
            <td align="center">{$vo.token}</td>
            <td align="center" class="aaa is_use{$vo.id}" isuse="{$vo.is_use}"><if condition="$vo['is_use'] eq 0">否<else />是</if></td>
            <td align="center">
            <?php
			$op = array();
			if(\Libs\System\RBAC::authenticate('edit')){
				$op[] = '<a href="'.U('MemberPublic/edit',array('id'=>$vo['id'])).'">修改</a>';
			}
			if(\Libs\System\RBAC::authenticate('delete')){
				$op[] = '<a class="J_ajax_del" href="'.U('MemberPublic/delete',array('id'=>$vo['id'])).'">删除</a>';
			}
			echo implode(" | ",$op);
			?> 
			| <a href="admin.php/MemberPublic/ching" mid="{$vo.id}" class="sf isuse">切换为当前公众号</a> | 
			<a href="admin.php/MemberPublic/help/id/{$vo.id}">接口帮助</a>
            </td>
          </tr>
        </volist>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} </div>
      </div>
  </div>
  <div class="btn_wrap">
      <div class="btn_wrap_pd">             
      	<label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit" data-action="{:U('index')}">排序</button>
        <?php
		if(\Libs\System\RBAC::authenticate('delete')){
		?>
        <button class="btn  mr10 J_ajax_submit_btn" type="submit">删除</button>
        <?php
		}
		?>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script type="text/javascript">
$(function(){
	var sf_num;
	$(".table_list table tbody tr").each(function(index,element){
		$(this).children().eq(5).children(".sf").click(function(){
			sf_num = index;
			if($(this).parent().prev().text() == "否"){
				$(this).parent().prev().text("是");
				$(this).parent().parent().siblings().children(".aaa").text("否");
			}else if($(this).parent().prev().text() == "是"){
				$(this).parent().prev().text("否");
				$(this).parent().parent().siblings().children(".aaa").text("否");
			}
		});
	});
	
	$('.isuse').click(function(){

		var url = $(this).attr('href');
		var id = $(this).attr('mid');
		var isUse = $('.is_use'+id).attr('isuse');
		$.ajax({
		   type: "POST",
		   url: url,
		   data: "isuse="+isUse+"&id="+id,
		   success: function(msg){
			 if(msg == '1'){
				$('.is_use'+id).attr('isuse',msg);
			 }else{
				$('.is_use'+id).attr('isuse',msg);
			 }
		   }
		}); 
		return false;
	})
})
</script>
</body>
</html>