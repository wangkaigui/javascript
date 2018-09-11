<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  <form action="{:U('WxManage/actionaddMenu')}" method="post" class="J_ajaxForm" >
	<table width="100%" >
		<tbody>
			<tr>
				<th width="10%">序号</th>
				<th width="30%">菜单名</th>
				<th width="30%">类型</th>
				<th width="20%">排序</th>
				<th width="10%">操作</th>
			</tr>
		</tbody>

		<volist name="menulist" id="voo">
			<tr>
				<td>{$voo.id}</td>
				<td>{$voo.title}</td>
				<td><if condition="$voo['leixin'] eq '1'">关键词：{$voo.keys}<else />链接跳转：{$voo.url}</if></td>																			
				<td><span class="form-group has-success has-feedback"><input type="text" name="{$voo.id}" value="{$voo.sort}" class="sorts" alt="{$voo.id}" onkeyup="this.value=this.value.replace(/[^\d]/g,'')"/></span></td>																			
				<td><a href="{:U('WxManage/delmenu',array('id'=>$voo['id']))}">删除</a></td>
			</tr>

			<volist name="voo['sub']" id="v1">
				<tr>
					<td>{$v1.id}</td>
					<td> 　　{$v1.title}</td>
					<td><if condition="$v1['leixin'] eq '1'">关键词：{$v1.keys}<else />链接跳转：{$v1.url}</if></td>	
					<td> <span class="form-group has-success has-feedback"><input type="text" name="{$v1.id}" value="{$v1.sort}" class="sorts" alt="{$v1.id}" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" /></span></td>											
					<td><a href="{:U('WxManage/delmenu',array('id'=>$v1['id']))}">删除</a></td>
				</tr>
		   </volist>

		</volist>
	</table>

		<div class="btn_wrap_pd">
			<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">生成到公众号</button>
      </div>
  </form>
  
</div>
  
  <script>
		$(".sorts").focusout(function(){
		var _this = $(this);
		var id = $(this).attr("alt");
		var sorts = $(this).val();
		$.ajax({
                    url:"{:U('WxManage/ajaxSort')}",
                    type:"POST",
                    dataType:"JSON",
                    data:{id:id,sorts:sorts},
                    success:function( data ){
                        if( data.ret == 1 ){
                            //alert(_this.patent());
                            _this.parent().removeClass().addClass("form-group has-success has-feedback");
                            _this.after("<span class='glyphicon glyphicon-ok form-control-feedback' aria-hidden='true'></span>").next().hide(3000);
                        }else{
                            _this.parent().removeClass().addClass("form-group has-error has-feedback");
                            _this.after("<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>").next().hide(3000);
                        }
                    }
		});
	});
  
  </script>

                                