<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
   <Admintemplate file="Common/Nav"/>
   <a href="{:U('Prize/add')}" >增加</a>
   <a id="del" href="javascript:void(0);" >删除</a>
   <div class="table_list">
    <form id="delform" class="J_ajaxForm" method="post" action="{:U('Prize/del')}">
  <table width="100%" cellspacing="0">
     	<thead>
        	<tr> 
        		<th width="5%"><input onclick="checkAll(this)" type="checkbox"></th>                
                <th width="5%" >奖项标题</th>
                <th width="10%" >奖项</th>
                <th width="10%" >名额数量</th>
                <th width="10%" >奖品图片</th>
                <th width="10%" >操作</th>
            </tr>
        </thead>
            <tbody>
              <tr>
              	  <foreach name="list" item="vo">
              	  	  <td><input class="checkbox" type="checkbox" value="{$vo.id}"></td>
                      <td>{$vo.title}</td>
                      <td>{$vo.name}</td>
                      <td>{$vo.num}</td>
                      <td><img src="{$vo.img}" width="50px" /></td>
                      <td>
                      	<a target="_self" href="{:U('Prize/edit',array('id'=>$vo['id']))}">编辑</a>
                      	<a target="_self" href="{:U('Prize/del',array('id'=>$vo['id']))}">删除</a>
                      </td>
                  </tr><tr>
                  </foreach>
             </tr>            
          </tbody>
     </table>
     </form>
      <div class="p10">
        <div class="pages"> {$Page} </div>
      </div>
   </div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script type="text/javascript">

$("#del").live('click',function(){
	$(".checkbox").each(function() {
		if($(this).is(":checked")){
			$(this).attr('name','id[]');
		}
	});
	$('#delform').submit();
})
function checkAll(obj){
	$('.checkbox').attr('checked',obj.checked);
}

function generates(genid){
	//生成静态
	if(genid == 1){
		$("#index_ruleid_1").show();
		$("#index_ruleid_1 select").attr("disabled",false);
		$("#index_ruleid_0").hide();
		$("#index_ruleid_0 select").attr("disabled","disabled");
	}else{
		$("#index_ruleid_0").show();
		$("#index_ruleid_0 select").attr("disabled",false);
		$("#index_ruleid_1").hide();
		$("#index_ruleid_1 select").attr("disabled","disabled");
	}
}
</script>
</body>
</html>