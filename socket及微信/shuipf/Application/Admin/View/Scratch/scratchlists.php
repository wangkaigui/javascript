<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<link type="text/css" rel="stylesheet" href="{$config_siteurl}statics/css/Base.css" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
   <Admintemplate file="Common/Nav"/>
   <div class="zj_lqq">
	   <a href="{:U('Scratch/add')}" >增加</a>
	   <a id="del" href="javascript:void(0);" >删除</a>
	   <div class="search-form fr cf">
	   		<form id="myform" class="J_ajaxForm" method="post" action="{:U(Scratch/scratchlists)}">
			<div class="sleft">
				<input class="lsText" type="text" placeholder="请输入关键字" value="" name="keyword">
				<input type="submit" value="搜索" class="lsButton" />
			</div>
			</form>
		</div>
   </div>
   <div class="table_list">
  <form id="delform" class="J_ajaxForm" method="post" action="{:U('Scratch/del')}">
  <table width="100%" cellspacing="0">
     	<thead>
        	<tr>
                <th width="5%"><input onclick="checkAll(this)" type="checkbox"></th>                
                <th width="5%" >刮刮卡ID</th>
                <th width="10%" >关键词</th>
                <th width="10%" >标题</th>
                <th width="10%" >获取人数</th>
                <th width="8%" >发布时间</th>
                <th width="10%" >操作</th>
            </tr>
        </thead>
            <tbody>
              <tr>
              	  <foreach name="list" item="vo">
                  <td><input  class="checkbox" type="checkbox" value="{$vo.id}" name=""></td>
                      <td>{$vo.id}</td>
                      <td>{$vo.keyword}</td>
                      <td>{$vo.title}</td>
                      <td>{$vo.collect_count}</td>
                      <td>
                      {$vo.cTime|date="Y-m-d",###}
                      </td>
                      <td>
                      	<a target="_self" href="{:U('Scratch/edit',array('id'=>$vo['id']))}">编辑</a>
                      	<a target="_self" href="{:U('Scratch/del',array('id'=>$vo['id']))}">删除</a>
                      	<a target="_self" href="{:U('Sn/snlists',array('id'=>$vo['id'],'show'=>'yes'))}">中奖管理</a>
                      	<a target="_self" href="{:U('Prize/prizelists',array('id'=>$vo['id']))}">奖品管理</a>
                      	<a target="black" href="{:U('Scratch/preview',array('id'=>$vo['id']))}">预览</a>
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