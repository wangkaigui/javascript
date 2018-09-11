<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<style>
    .hiddens{display:none}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  
  <form action="{:U('WxManage/createMenu')}" method="post" >
    <div class="table_full">
      
	  
	  
		<table>
		   <tbody>
			   <tr>
				   <td>菜单标题</td>
				   <td><input type="text" id="title" style="width:250px;" name="title" placeholder="自定义菜单不超过16个字节"></td>
			   </tr>

			   <tr>
				   <td>菜单级别:</td>		
				   <td>
					   <input type="radio" value="0" id="zhu" name="pid"  checked />主菜单
					   <input type="radio"  id="er" name="pid" />二级菜单
				   </td>
			   </tr>


				 <tr class="hiddens" id="shanji">
					   <td>上级菜单</td>
					   <td>
						 <select name="pid"  >	
							   <option value="0">一级菜单</option>						  
							   <volist name="menu" id="vo">
									<option value="{$vo.id}">{$vo.title}</option>
							   </volist>
						 </select>
					   </td>
				 </tr>


				 <tr>
					   <td>菜单类型:</td>
					   <td>
							<input type="radio" value="0" id="link" name="leixin" checked />链接跳转	
							<input type="radio" value="1" id="dianji" name="leixin" />内容回复			
					   </td> 
				 </tr>
				 <tr id="links">
					   <td for="url" >跳转链接</td>
					   <td><input type="text" id="url" name="url" placeholder="跳转链接"></td>
				 </tr>

				<tr id="keys" class='hiddens'>
					<td for="keys">关键词</td>
					   <td>
						<select name="keys" style="width:150px;">						
							   <volist name="keys" id="vo">
									<option value="{$vo.key}">{$vo.key}</option>
							   </volist>
						 </select>
					</td>
				</tr>

				<tr>
					   <td for="sorts">排序</td>
					   <td><input type="text" id="sorts" value="100" /></td>
				</tr>

		   </tbody>
		   
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
    $("#dianji").click(function(){
        $("#links").addClass("hiddens");
        $("#keys").removeClass("hiddens");
        });
        $("#link").click(function(){
            $("#links").removeClass("hiddens");
            $("#keys").addClass("hiddens");
        });
        $("#er").click(function(){
            $("#shanji").removeClass("hiddens");
        });
        $("#zhu").click(function(){
            $("#shanji").addClass("hiddens");
        });
	
	
		function ajaxGet(catid){
		$.ajax({
			type: "POST",
			url: "index.php?g=Admin&m=PatentManage&a=ajaxChange",
			dataType:'json',
			data: {
				'catid':catid,
			},
			success: function(data){	
				if (data.ret == 1) {
                    var d = data.data;
                    if (d != null && d != '') {
                        count = d.length;
                        var option = '<option value="">请选择</option>';
                        for (i = 0; i < count; i++) {
                            option += "<option value='" + d[i].catid + "'>" + d[i].catname + "</option>";
                        }
                        $("#serviceTypeId").html(option);
                        
                    } else {
                        $("#serviceTypeId").html('<option value="">暂无相关类</option>');
                    }
                }else {
                        $("#serviceTypeId").html('<option value="">暂无相关类</option>');
                    }	
			},
			error:function(){
				
			},
		});
	}
</script>