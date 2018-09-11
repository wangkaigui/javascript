<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>

<style>
	.reduceDis{display:none}
	.reduceBlo{display:block}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  
  <form action="{:U('WxManage/sendText')}" method="post" >
  
	
    <div class="table_full">
      <table   class="table_form">
		
		<tr style="width:100px;">
			<th>请输选择用户组：</th>
			<td class="y-bg">
				<select name='groupid' class="chageType" style="width:100px;">
					<option value='' >全部</option>
					<volist name="grouplist" id="vo">
						<option value='{$vo.groupid}'>{$vo.groupname}</option>
					</volist>
				</select>	
			</td>
		</tr>

			<tr id="textId" style="width:80px;">
				<th>请输入发送内容：</th>
				<td class="y-bg">
					<textarea style="width:300px;height:160px;" name='msg'></textarea>
				</td>
			</tr>
		
      </table>
    </div>
	
    <div class="">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">发送</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
</body>
</html>

<script>


</script>