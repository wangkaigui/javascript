/**js交互**/

//线路分类下拉
$(function(){
	
	//FastClick.attach(document.body);
	
    $(".flarea").find("em").click(function(){
       $(this).next().toggle();
    });
    $(".slist").click(function(){
        tnum();
    });
    

    

    //会员升级单选

    //我的订单选项卡
    $(".orderfl").find("li").click(function(){
        var liindex = $(this).index();
        $(this).addClass("on").siblings().removeClass("on");
        $(".orderlist").find("ul").eq(liindex).show().siblings().hide();
    });

    



})

//选择数量
function tnum() {
    $(".hidecart").fadeIn(200);
    $(".carea").show().stop().animate({"bottom": "0"}, 200);
    $("body").css("overflow", "hidden");
    $(".hidecart").click(function () {
        $(this).fadeOut(200);
        $(".carea").stop().animate({"bottom": "-13rem"}, 200);
        $("body").css("overflow", "auto");
    });
    $(".close").click(function(){
        $(".hidecart").fadeOut(200);
        $(".carea").stop().animate({"bottom": "-13rem"}, 200);
        $("body").css("overflow", "auto");
    });
}

