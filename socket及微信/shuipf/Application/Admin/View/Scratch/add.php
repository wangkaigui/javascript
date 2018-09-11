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
    <form enctype="multipart/form-data" id="myform" class="J_ajaxForm" method="post" action="{:U(Coupon/add)}">
    <div class="clearfix">
        <ul class="fl lsList_ul">
            <li>
                <span><em>*</em>关键词</span>
                <input name="keyword" type="text" value="" class="listText" />
            </li>
            
            <li>
                <span><em>*</em>标题</span>
                <input name="title" type="text" value="" class="listText" />
            </li>
            
            <li>
                <span>封面简介</span>
                <textarea name="intro" class="listRea"></textarea>
            </li>
            
            <li class="listBox">
                <span>封面图片<i>(可为空)</i></span>
                <a href="#" class="lsList_a cover"><img id="cover" src="{$config_siteurl}statics/images/wx/btn_01.png" /></a>
            	<input type="file" name="cover" class="listFile cover_up"  />
            </li>
            
            <li>
                <span><em>*</em>使用说明<i>(用户获取优惠券后显示的提示信息)</i></span>
                <textarea name="use_tips" class="listRea"></textarea>
            </li>
            
            <li>
                <span>开始时间</span>
                <input onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',isShowClear:false,isShowToday:false,isShowOK:false,qsEnabled:false,autoPickDate:true})" name="start_time"  type="text" placeholder="请选择时间" class="listText" />
            </li>
            
            <li>
                <span>结束时间</span>
                <input onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',isShowClear:false,isShowToday:false,isShowOK:false,qsEnabled:false,autoPickDate:true})" name="end_time"  type="text" placeholder="请选择时间" class="listText" />
            </li>
            
            <li>
                <span>过期说明<i>(活动过期或者结束说明)</i></span>
                <textarea name="end_tips" class="listRea"></textarea>
            </li>
            
            <li class="listBox">
                <span>过期提示图片<i>(可为空)</i></span>
                <a href="#" class="lsList_a end_img"><img id="end_img" src="{$config_siteurl}statics/images/wx/btn_01.png" /></a>
            	<input type="file" name="end_img" class="listFile end_img_up" />
            </li>
            
            <li>
                <span><em>*</em>预计参与人数 （预计人数直接影响抽奖概率：中奖概率 = 奖品总数/(预估活动人数*每人抽奖次数) 要确保100%中奖可设置 </i></span>
                <input name="predict_num" type="text" value="1" class="listText_02" />
            </li>
            
            <li>
                <span>粉丝状态<i>(粉丝达到设置的状态才能获取)</i></span>
                <select name="follower_condtion" class="listSel">
                    <option value="0">不限制 </option>
					<option selected="" value="1">已关注 </option>
					<option value="2">已绑定信息 </option>
					<option value="3">会员卡成员 </option>
                </select>
            </li>
            
            <li>
                <span>每人最多允许获取次数<i>(（0表示不限制数量）)</i></span>
                <input name="max_num" type="text" value="0" class="listText_02" />
            </li>
            
             <li>
                <span>积分限制<i>(粉丝达到多少积分后才能领取，领取后不扣积分)</i></span>
                <input name="credit_conditon" type="text" value="0" class="listText_02" />
            </li>
            
            <li>
                <span>积分消费<i>(用积分中的财富兑换、兑换后扣除相应的积分财富)</i></span>
                <input name="credit_bug" type="text" value="0" class="listText_02" />
            </li>
            
            <li>
                <span>插件场景限制<i>(格式：[插件名：id值],如[投票：10]表示对ID为10的投票投完才能领取,更多的说明见表单上的提示)</i></span>
                <input name="addon_condition" type="text" value="" class="listText" />
            </li>
            
            <li>
                <input type="submit" value="确&nbsp;定" class="listBtn" />
            </li>
        </ul>
        
        <div class="fr ListImg">
            <h2>微信回复预览</h2>
            <span id="show_title"></span>
            <h3>
            <img id="show_img" src="{$config_siteurl}statics/images/wx/Img_02.jpg" width="288px" height="145px"/>
            </h3>
            <span id="show_intro" ></span>
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
