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
            <td width="6%"  align="center"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">全选</td>
            <td width="10%">排序</td>
            <td align="center" width="15%">菜单名</td>
            <td align="center" width="15%">关联关键词</td>
            <td align="center" width="25%">关联URL</td>
            <td align="center" width="25%">操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="lists" id="vo">
          <tr>
            <td width="50"><input type="checkbox" value="{$vo.tagid}" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="tagid[]">
			<input type="hidden" mid="{$vo.id}">
			{$vo.id}
			</td>
            <td><input type="text" name="listorder[{$vo.id}]" class="input" value="{$vo.sort}" size="5" /></td>
            <td align="left">{$vo.title}</td>
			<td align="center">{$vo.keyword}</td>
            <td align="center">{$vo.url}</td>
            <td align="center">
            <?php
			$op = array();
			if(\Libs\System\RBAC::authenticate('edit')){
				$op[] = '<a href="'.U('CustomMenu/edit',array('id'=>$vo['id'])).'">修改</a>';
			}
			if(\Libs\System\RBAC::authenticate('delete')){
				$op[] = '<a class="J_ajax_del" href="'.U('CustomMenu/delete',array('id'=>$vo['id'])).'">删除</a>';
			}
			echo implode(" | ",$op);
			?> 
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
</body>
</html>