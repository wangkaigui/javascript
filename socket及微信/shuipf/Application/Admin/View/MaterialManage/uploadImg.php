<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<style>
    .hiddens{display:none}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">模型属性</div>
  
  <form action="{:U('MaterialManage/addImg')}" method="post" id="subid">
    <div class="table_full">
      
	  
	  
		<table>
		   <tbody>
				
				   
					<tr style="color:red;">
					<td>说明*</td>
					<td> 图片（image）: 2M，支持bmp/png/jpeg/jpg/gif格式<br/>
						语音（voice）：2M，播放长度不超过60s，mp3/wma/wav/amr格式<br/>
						视频（video）：10MB，支持MP4格式<br/>
						缩略图（thumb）：64KB，支持JPG格式<br/>
					</td>
					</tr>
					
					<td>请选择类型</td>
					<td>
						<select name="uploadtype" onchange="change($(this).val());">
							<option value='image'>图片类型</option>
							<option value='thumb'>缩略图类型</option>
							<option value='voice'>语音类型</option>
							<option value='video'>视频图类型</option>
						</select>
					</td>
				   <tr>
					
					<tr>
						<td>请输入标题</td>
						<td><input type="text" name='title'></td>
					</tr>
					
					<tr style="display:none" id="voiceId">
					<td>请输入视频说明</td>
						<td><textarea name="description" id="description"></textarea></td>
					</tr>
					
			   <tr>
				   <td>上传图片</td>
				   <td><input type="file" id="uploadFile" style="width:250px;" name="uploadFile" onchange="ajaxUpload();"></td>
				   
			   </tr>
			<input type="hidden" id="uploadPath" name="filepath">
			<input type="hidden" id="uploadName" name="name">
			<input type="hidden" id="uploadType" name="type">
			<input type="hidden" id="uploadSize" name="size">
		   </tbody>
		   
		 </table>    

    </div>
    <div class="">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="button" onclick="check();">添加</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
<script src="{$config_siteurl}statics/js/artDialog/dialog.js"></script>
</body>
</html>

<script>
    function ajaxUpload(){
       var formData = new FormData($( "#subid" )[0]);
    /*   if(filename==''){
            modalAlert('警告','请选择要上传的文件','');
            return false;
       }*/
       $.ajax({
        type: "POST",
        data:formData,
        autoSubmit: true,
        url: "index.php?g=Admin&m=MaterialManage&a=uploadImg",
        enctype: 'multipart/form-data',
        async: false,
        dataType:'json',
        cache: false,
        contentType: false,
        processData: false,
    /*    beforeSend: function () {
            //禁用按钮防止返回后重复提交
            $("#upBtb").attr({ disabled: "disabled" });
        },*/
        success: function (data) {
            if(data.isError==false){
                $("#uploadPath").val(data.uploadInfo.uploadFile['savename']);
                $("#uploadName").val(data.uploadInfo.uploadFile['name']);
                $("#uploadType").val(data.uploadInfo.uploadFile['type']);
                $("#uploadSize").val(data.uploadInfo.uploadFile['size']);
                artDiaLog('文件上传成功');
            }else if(data.isError==true){
                artDiaLog('文件上传失败');
                window.location.href=window.location.href;
            }
            
        }
    });
}

function artDiaLog(msg){
	var d = dialog({
		title: '警告',
		content: msg,
		okValue: '确 定'
	});
	d.show();
	return false;
}

function check(){
	if($("#uploadFile").val()==''){
		artDiaLog('请选择要上传的文件');
		return false;
	}else if($("select[name=uploadtype] option[selected]").val()=='vodeo'){
		if($("#description").val()==''){
			artDiaLog('视频说明不能为空');
			return false;
		}
	}else if($("input[name='title']").val()==''){
		artDiaLog('请输入标题');
		return false;
	}else{
		$("#subid").submit();
	}
}

function change(type){
	if(type=='video'){
		$("#voiceId").attr('style','display:');
	}else{
		$("#voiceId").attr('style','display:none');
	}
}
</script>