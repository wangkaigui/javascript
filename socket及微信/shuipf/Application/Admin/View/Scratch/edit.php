<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<link type="text/css" rel="stylesheet" href="{$config_siteurl}statics/css/Base.css" />

<script type="text/javascript" src="{$config_siteurl}statics/DatePicker/WdatePicker.js"></script>

<body>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <div class="lsList" style="background:#fff;">
	<div class="lsListTop">
    	<img src="{$config_siteurl}statics/images/wx/Icon_03.jpg" />
       	 插件场景限制参数说明：格式：[插件名id]，如<br />
        [投票：10]，表示对ID为10的投票投完对能领取<br />
        [投票：*]，表示只要投过票就可以领取<br />
        [微调研：15]，表示完成ID为15的调研就能领取<br />
        [微考试：10]，表示完成ID为10的考试就能领取
    </div>
    <form enctype="multipart/form-data" id="myform" class="J_ajaxForm" method="post" action="{:U(Coupon/edit)}">
    <input type="hidden" name="id" value="{$data.id}" />
    <div class="clearfix">
        <ul class="fl lsList_ul">
            <li>
                <span><em>*</em>关键词</span>
                <input value="{$data.keyword}" name="keyword" type="text" value="" class="listText" />
            </li>
            
            <li>
                <span><em>*</em>标题</span>
                <input value="{$data.title}" name="title" type="text" value="" class="listText" />
            </li>
            
            <li>
                <span>封面简介</span>
                <textarea name="intro" class="listRea">{$data.intro}</textarea>
            </li>
            
            <li class="listBox">
                <span>封面图片<i>(可为空)</i></span>
                <a href="#" class="lsList_a cover"><img id="cover" src="{$data.cover}" /></a>
            	<input type="file" name="cover" class="listFile cover_up"  />
            </li>
            
            <li>
                <span><em>*</em>使用说明<i>(用户获取优惠券后显示的提示信息)</i></span>
                <textarea name="use_tips" class="listRea">{$data.use_tips}</textarea>
            </li>
            
            <li>
                <span>开始时间</span>
                <input value="{$data.start_time|date="Y-m-d H:i:s",###}" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',isShowClear:false,isShowToday:false,isShowOK:false,qsEnabled:false,autoPickDate:true})" name="start_time"  type="text" placeholder="请选择时间" class="listText" />
            </li>
            
            <li>
                <span>结束时间</span>
                <input value="{$data.end_time|date="Y-m-d H:i:s",###}" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',isShowClear:false,isShowToday:false,isShowOK:false,qsEnabled:false,autoPickDate:true})" name="end_time"  type="text" placeholder="请选择时间" class="listText" />
            </li>
            
            <li>
                <span>过期说明<i>(活动过期或者结束说明)</i></span>
                <textarea name="end_tips" class="listRea">{$data.end_tips}</textarea>
            </li>
            
            <li class="listBox">
                <span>过期提示图片<i>(可为空)</i></span>
                <a href="#" class="lsList_a end_img"><img id="end_img" src="{$data.end_img}" /></a>
            	<input type="file" name="end_img" class="listFile end_img_up" />
            </li>
            
            <li>
                <span><em>*</em>预计参与人数 （预计人数直接影响抽奖概率：中奖概率 = 奖品总数/(预估活动人数*每人抽奖次数) 要确保100%中奖可设置 </i></span>
                <input value="{$data.predict_num}" name="predict_num" type="text" value="1" class="listText_02" />
            </li>
            
            <li>
                <span>粉丝状态<i>(粉丝达到设置的状态才能获取)</i></span>
                <select name="follower_condtion" class="listSel">
                    <option {$data['selected_0']} value="0">不限制 </option>
					<option {$data['selected_1']} value="1">已关注 </option>
					<option {$data['selected_2']} value="2">已绑定信息 </option>
					<option {$data['selected_3']} value="3">会员卡成员 </option>
                </select>
            </li>
            
            <li>
                <span>每人最多允许获取次数<i>(（0表示不限制数量）)</i></span>
                <input value="{$data.max_num}" name="max_num" type="text" value="0" class="listText_02" />
            </li>
            
             <li>
                <span>积分限制<i>(粉丝达到多少积分后才能领取，领取后不扣积分)</i></span>
                <input value="{$data.credit_conditon}" name="credit_conditon" type="text" value="0" class="listText_02" />
            </li>
            
            <li>
                <span>积分消费<i>(用积分中的财富兑换、兑换后扣除相应的积分财富)</i></span>
                <input value="{$data.credit_bug}" name="credit_bug" type="text" value="0" class="listText_02" />
            </li>
            
            <li>
                <span>插件场景限制<i>(格式：[插件名：id值],如[投票：10]表示对ID为10的投票投完才能领取,更多的说明见表单上的提示)</i></span>
                <input value="{$data.addon_condition}"name="addon_condition" type="text" value="" class="listText" />
            </li>
            
            <li>
                <input type="submit" value="确&nbsp;定" class="listBtn" />
            </li>
        </ul>
        
        <div class="fr ListImg">
            <h2>微信回复预览</h2>
            <span id="show_title">{$data.title}</span>
            <h3>
            <img id="show_img" src="{$config_siteurl}statics/images/wx/Img_02.jpg" width="288px" height="145px"/>
            </h3>
            <span id="show_intro" >{$data.intro}</span>
        </div>
    </div>
    </form>
	</div>
</div>
</div>
</body>
<script type="text/javascript">
	$(function(){
		$("input[name='title']").keyup(function(){
			var str = $(this).val();
			$('#show_title').html(str);

		});

		$("textarea[name='intro']").keyup(function(){
			var str = $(this).val();
			$('#show_intro').html(str);

		});
			
	})
	$(function () {
     	$(".cover_up").uploadPreview({ Img: "cover", Width: 120, Height: 120,Callback: function () { 
				$('#show_img').attr('src',$('#cover').attr('src'));
         	} });
     });
	$(function(){
		$(".cover").click(function(){
			$(".cover_up").click();
			return false;
		});
	})
	 $(function () {
     	$(".end_img_up").uploadPreview({ Img: "end_img", Width: 120, Height: 120 });
     });
	$(function(){
		$(".end_img").click(function(){
			$(".end_img_up").click();
			return false;
		});
	})
</script>
</html>
