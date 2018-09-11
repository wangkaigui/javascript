<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  <form action="{:U("setConfig")}" method="post" class="J_ajaxForm" >
<table width="100%">
	<tbody>
		<tr>
			<td width="140">APPkey</td>
			<td><input type="text" style="width:220px;height:22px;" name="appid" value="{$info.appid}" /></td>
		</tr>

		<tr>
			<td>APPsecret</td>
			<td><input type="text" style="width:220px;height:22px;" name="secret" value="{$info.secret}" /></td>
		</tr>
		
	</tbody>
</table>


		<div class="btn_wrap_pd">
			<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">保存</button>
      </div>
  </form>
  
</div>