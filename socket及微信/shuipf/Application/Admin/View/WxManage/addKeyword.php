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
  
  <form action="{:U('WxManage/addkeyword')}" method="post" >
  
	
    <div class="table_full">
      <table   class="table_form">
		
		<tr style="width:100px;">
			<th>请输选择回复类型：</th>
			<td class="y-bg">
				<select name='leixin' class="chageType" style="width:100px;">
					<option value='0' >关注回复</option>
					<option value='1' >文本类型</option>
					<option value='2' >图文类型</option>
				</select>
			</td>
		</tr>
	  
		<tr style="width:80px;display:none;" id="keywods">
			<th>请输入关键字：</th>
			<td class="y-bg"><input type="text" class="input" name="key" size="30"  /></td>
		</tr>
		
		
		
			<tr style="width:80px;display:none;" id="imgId">
				<th>请输选择文章：</th>
				<td class="y-bg">
					<select name='cid' style="width:150px;">
						<volist name="data" id="vo" key="key">
							<option value='{$vo.id}'>{$vo.title}</option>
						</volist>
					</select>
				</td>
			</tr>
		
			<tr id="textId" style="width:80px;">
				<th>请输入回复内容：</th>
				<td class="y-bg">
					<textarea style="width:300px;height:160px;" name='text'></textarea>
				</td>
			</tr>
		
      </table>
    </div>
	
    <div class="">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
</body>
</html>

<script>
$(".chageType").change(function(){
	var id=$(this).val();
	if(id==1){
		$("#textId").attr('style','display:;width:80px;');
		$("#imgId").attr('style','display:none;width:80px;');
		$("#keywods").attr('style','display:;width:80px;');
	}else if(id==2){
		$("#textId").attr('style','display:none;width:80px;');
		$("#imgId").attr('style','display:;width:80px;');
		$("#keywods").attr('style','display:;width:80px;');
	}else if(id==0){
		$("#textId").attr('style','display:;width:80px;');
		$("#imgId").attr('style','display:none;width:80px;');
		$("#keywods").attr('style','display:none;width:80px;');
	}
});

</script>