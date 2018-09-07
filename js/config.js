
// const API_ROOT = 'http://www.jindianim.com';
const API_ROOT = 'http://www.yueyu.com';

const URL_TYPE = {
	'ADMIN': 'admin',
	'USER': 'user',
	'PUBLIC': 'public',
	'FILE': 'file'
}
const URL_METHOD = {
	GET: 'get',
	POST: 'post',
}
const urls={
	
	/*********通用类接口**********/
	getIndexBanner: {
		path: '/api.php?m=News&a=getIndexBanner',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取首页banner图'
	},
	
	getIndexPackage: {
		path: '/api.php?m=News&a=getIndexPackage',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取298套餐'
	},
	
	getIndexListLuck: {
		path: '/api.php?m=News&a=getIndexListLuck',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '首页list_luck'
	},
	
	getIndexPackages: {
		path: '/api.php?m=News&a=getIndexPackages',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '首页特权专区'
	},
	
	getLsProductList: {
		path: '/api.php?m=News&a=getLsProductList',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '新零售商品'
	},
	
	getProductDetail: {
		path: '/api.php?m=News&a=getProductDetail',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '商品详情'
	},
	getTravelList: {
		path: '/api.php?m=News&a=getTravelList',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '新旅行列表'
	},
	companyGuide: {
		path: '/api.php?m=News&a=companyGuide',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '公司简介'
	},
	getTuiBianList: {
		path: '/api.php?m=News&a=getTuiBianList',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '蜕变之美列表'
	},
	getNewsDetail: {
		path: '/api.php?m=News&a=getNewsDetail',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '新闻详情'
	},
	tuiBianBanner: {
		path: '/api.php?m=News&a=tuiBianBanner',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '蜕变之美banner'
	},
	getZhuanJia: {
		path: '/api.php?m=News&a=getZhuanJia',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '蜕变之美banner'
	},
	
	getShareSpace: {
		path: '/api.php?m=News&a=getShareSpace',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '共享空间'
	},
	
	getShareSpaceBanner: {
		path: '/api.php?m=News&a=getShareSpaceBanner',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '共享空间banner'
	},
	getEducationList: {
		path: '/api.php?m=News&a=getEducationList',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '新教育'
	},
	
	
	getMenuInfo: {
		path: '/api.php?m=News&a=getMenuInfo',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '新零售商城'
	},
	getSysteamMessage: {
		path: '/api.php?m=News&a=getSysteamMessage',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取系统消息'
	},
	
	
	
	/********用户中心center接口************/
	getIntegral: {
		path: '/api.php?m=Center&a=getIntegral',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '奖励明细'
	},
	
	getPayLogs: {
		path: '/api.php?m=Center&a=getPayLogs',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '消费记录'
	},
	
	getOrderSearch: {
		path: '/api.php?m=Center&a=getOrderSearch',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '幸运查询'
	},
	
	getMyTeams: {
		path: '/api.php?m=Center&a=getMyTeams',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取我的团队'
	},
	
	getMemberInfo: {
		path: '/api.php?m=Center&a=getMemberInfo',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取我的团队'
	},
	
	getShareCentre: {
		path: '/api.php?m=Center&a=getShareCentre',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取个人中心'
	},
	
	ajaxGetAtotal: {
		path: '/api.php?m=Center&a=ajaxGetAtotal',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '异步请求积分信息'
	},
	
	exchangeShopBalance: {
		path: '/api.php?m=Center&a=exchangeShopBalance',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '兑换积分动作'
	},
	
	getListLuck: {
		path: '/api.php?m=Center&a=getListLuck',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取幸运补贴列表'
	},
	
	getShareCentre: {
		path: '/api.php?m=Center&a=getShareCentre',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取分享中心'
	},
	
	acRecharge: {
		path: '/api.php?m=Center&a=acRecharge',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '会员充值动作'
	},
	
	getOrderInfo: {
		path: '/api.php?m=Center&a=getOrderInfo',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取订单信息'
	},
	
	getMyOrderList: {
		path: '/api.php?m=Center&a=getMyOrderList',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取我的订单列表'
	},
	
	getBankList: {
		path: '/api.php?m=Center&a=getBankList',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取提现银行'
	},
	
	actionApplyFor: {
		path: '/api.php?m=Center&a=actionApplyFor',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '申请提现动作'
	},
	
	getHisApplyInfo: {
		path: '/api.php?m=Center&a=getHisApplyInfo',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取历史提现信息'
	},
	
	updateMyData: {
		path: '/api.php?m=Center&a=updateMyData',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '更新个人资料'
	},
	
	ajaxUploadImg: {
		path: '/api.php?m=Center&a=ajaxUploadImg',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '异步上传头像'
	},
	
	getProductNewsDetail: {
		path: '/api.php?m=Center&a=getProductNewsDetail',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '新闻详情'
	},
	
	getShopIndexInfo: {
		path: '/api.php?m=Center&a=getShopIndexInfo',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '新零售商城'
	},
	
	actionCart: {
		path: '/api.php?m=Center&a=actionCart',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '操作购物车'
	},
	
	getCartinfo: {
		path: '/api.php?m=Center&a=getCartinfo',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取购物车信息'
	},
	
	confirmCart: {
		path: '/api.php?m=Center&a=confirmCart',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '从购车车下单'
	},
	
	getSubCartInfo: {
		path: '/api.php?m=Center&a=getSubCartInfo',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取购车提交信息'
	},
	subOrderCheck: {
		path: '/api.php?m=Center&a=subOrderCheck',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '购物车提交验证'
	},
	
	setUserAgent: {
		path: '/api.php?m=Center&a=setUserAgent',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '设置上一级分享人'
	},
	
	placeCartOrder: {
		path: '/api.php?m=Center&a=placeCartOrder',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '购物车下单'
	},
	
	getUserAddress: {
		path: '/api.php?m=Center&a=getUserAddress',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取收货地址'
	},
	
	orderBuy: {
		path: '/api.php?m=Center&a=orderBuy',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '直接购买下单'
	},
	
	getUserAddressList: {
		path: '/api.php?m=Center&a=getUserAddressList',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取用户地址列表'
	},
	
	addressEdit: {
		path: '/api.php?m=Center&a=addressEdit',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '编辑收货地址'
	},
	
	saveAddress: {
		path: '/api.php?m=Center&a=saveAddress',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '操作用户地址'
	},
	
	getAddressInfoById: {
		path: '/api.php?m=Center&a=getAddressInfoById',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '获取地址信息'
	},
	
	scorePay: {
		path: '/api.php?m=Center&a=scorePay',
		type: URL_TYPE.PUBLIC,
		method: URL_METHOD.GET,
		commonts: '积分支付',
	},
	
	/********用户user接口**********************/
	
}
    


function myHttp(options){
    var url = API_ROOT + options.url;
    var params = options.params;
    var successCallback = options.success || function (res) {};
    $.ajax({
        type: "POST",
        data: params,
        async: true,
        headers:options.headers,
        dataType: "json",
        url: url,
        //contentType: "text/plain",
        beforeSend: function (res) {
            // res.setRequestHeader("accessToken", "Chenxizhang");
        },
        success: function (res) {
            successCallback(res);
        },
        error: function (res) {
            //console.log(res)
        }
    });
}




 function getQueryString(url,name) {
    var reg = new RegExp("([^|&]|[^|?])" + name + "=([^&]*)(&|$)", "i");
    var reg_rewrite = new RegExp("(^|/)" + name + "/([^/]*)(/|$)", "i");
    var arr=[];
    var turl = null;
    if(reg.test(url)){
        turl = (reg.exec(url));
    }else if(reg_rewrite.test(url)){
        turl = (reg_rewrite.exec(url));
    }

    for(var i in turl){
        arr[i] = turl[i];
    }
    return (arr[2]);
}

function tojson(arr){
	if(!arr.length) return null;

	var i = 0;
	len = arr.length,
	array = [];
	for(;i<len;i++){
		array.push({"projectname":arr[i][0],"projectnumber":arr[i][1]});
	}
	return JSON.stringify(array);

}

 String.prototype.myReplace=function(f,e){
    var reg=new RegExp(f,"g");
    return this.replace(reg,e); 
}

//加载分页
if (!NeuF) var NeuF = {};
NeuF.ScrollPage = function (obj, options, callback) {
    var _defaultOptions = { delay: 500, marginBottom: 50 };
    options = $.extend(_defaultOptions, options);
    this.isScrolling = false; //是否在滚动
    this.oriPos = 0; //原始位置
    this.curPos = 0; //当前位置
    var me = this; //顶层
    var $obj = (typeof obj == "string") ? $("#" + obj) : $(obj);

    $obj.scroll(function (ev) {
        me.curPos = $obj.scrollTop();
        if ($(window).height() + $(window).scrollTop() >= $(document.body).height() - options.marginBottom) {
            if (me.isScrolling == true) return;
            me.isScrolling = true;
            setTimeout(function () { me.isScrolling = false;}, options.delay); //重复触发间隔毫秒;
            if (typeof callback == "function") callback.call(null, me.curPos - me.oriPos);
        };
        me.oriPos = me.curPos;
    });
};


var u = navigator.userAgent, app = navigator.appVersion;
// var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
var isiOS = !u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1;
if(!NATIVE) var NATIVE = {};

//一级页面跳转首页
NATIVE.toIndex2 = function (){
    if(isiOS){
        ToHome(1);
    }else{
        jindianwebjs.ToHome(1);
    }
}

//其他子页面跳转首页
NATIVE.toIndex = function (){
    if(isiOS){
        TaskToHome(1);
    }else{
        jindianwebjs.TaskToHome(1);
    }
}

//关闭webview 首页进入其他h5返回时调用
NATIVE.closeWinView = function (){
    if(isiOS){
        closeWinView(false);
    }else{
        jindianwebjs.closeWinView(false);
    }

}

//设置亮度 i : 0-255
NATIVE.saveScreenBrightness = function (i){
    if(isiOS){
        saveScreenBrightness(i);
    }else{
        jindianwebjs.saveScreenBrightness(i);
    }
}

//设置系统自动亮度
NATIVE.startAutoBrightness = function (){
    if(isiOS){
        startAutoBrightness()
    }else{
        jindianwebjs.startAutoBrightness();
    }

}

//跳转到个人中心
NATIVE.toAccount = function (){
    NATIVE.closeWinView();
    // if(isiOS){
    //     toAccount();
    // }else{
    //     jindianwebjs.toAccount();
    //     //window.history.back();
    // }
}

//跳转登录页面
NATIVE.toLogin = function (){
    if(isiOS){
        ToLogin();
    }else{
        jindianwebjs.ToLogin();
    }
}

//登出
NATIVE.outLogin = function (){
    if(isiOS){
        OutLogin();
    }else{
        jindianwebjs.OutLogin();
    }
}

//微信支付
NATIVE.wechatpay = function (amount){
    if(parseFloat(amount)<=0){
        myAlert('请输入正确的充值金额');
        return false;
    }
    myAlert(parseFloat(amount));
    if(isiOS){
        wechatpay(parseFloat(amount));
    }else{
        jindianwebjs.wechatpay(parseFloat(amount));
    }
}



var winurl = window.location.href ;
var accessToken = getQueryString(winurl, 'accessToken') ;
if(accessToken =='undefined' || accessToken =='' || accessToken == null){
    accessToken = 'Q6j3xOrR';
}


document.write("<script language=javascript src='js/layer/layer.js'></script>");
document.write('<div class="loading" style="display: none;" ><img src="../images/loading.gif"></div>');


function myAlert(msg){
    layer.msg(msg);
    //console.log(123);
}

//跳转到指定页面
function locationUrl(url,hasParam){
	
	if(isAndroid){
        jindianwebjs.pushPage(url);
    }else{
        if(hasParam){
            window.location.href=url+"&accessToken="+accessToken;
        }else{
            window.location.href=url+"?accessToken="+accessToken;
        }
    }
	
	/*
    if(isiOS){
        // if(hasParam){
        //     window.location.href=url+"?accessToken="+accessToken;
        // }else{
        //     window.location.href=url+"?accessToken="+accessToken;
        // }
        pushPage(url);
    }else if(isAndroid){
        jindianwebjs.pushPage(url);
    }else{
        if(hasParam){
            window.location.href=url+"&accessToken="+accessToken;
        }else{
            window.location.href=url;
        }
    }
*/

}

var Clih = document.documentElement.clientHeight || document.body.clientHeight;
$(function(){
    var headerH = $(".myheader").height();
    var overH = Clih - headerH;
    document.getElementsByClassName("loading")[0].style.height = overH + "px";
    document.getElementsByClassName("loading")[0].style.top = headerH + "px";
})



//参数签名
function sign(data){
   
   var time = Date.parse(new Date());
   var key1 = CryptoJS.enc.Hex.parse(KEY_D);
   var iv  = CryptoJS.enc.Hex.parse(KEY_H);
   var opinion = {iv:iv, padding:CryptoJS.pad.ZeroPadding};   
   var encrypted = CryptoJS.AES.encrypt(INTERFACE_KEY+time, key1, opinion);
   var encrypted = encrypted.toString();
   data['time'] = time+getRandNum(8);
   data['identity_code'] = encrypted;
    //url_parmars+='&sign='+hex_md5(url_parmars+'&key=ksjshakj12434ks1')
    //return url_parmars;
    return data;
 }
 
 
 function log(data){
	 console.log(data);
 }

