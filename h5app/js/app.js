$(document).bind("mobileinit", function () {
    $.mobile.pushStateEnabled = true;
});

$(function () {
    var menuStatus;
    var show = function() {
        if(menuStatus) {
            return;
        }
        $('#menu').show();
		$(".header").animate({
				left:"17.2em"
				},300)
		$(".footer").animate({
				left:"17.2em"
				},300)
        $.mobile.activePage.animate({
            marginLeft: "17.2em",
			
        }, 300, function () {
            menuStatus = true;
			$('html').css("overflow","hidden")
        });
    };
    var hide = function() {
        if(!menuStatus) {
            return;
        }
		$(".header").animate({
				left:"0"
				},300)
		$(".footer").animate({
				left:"0"
				},300)
        $.mobile.activePage.animate({
            marginLeft: "0px",
        }, 300, function () {
            menuStatus = false
            $('#menu').hide();
			$('html').css("overflow","auto")
        });
    };
    var toggle = function() {
        if (!menuStatus) {
            show();
        } else {
            hide();
        }
        return false;
    };
    // Show/hide the menu
    $("a.showMenu").click(toggle);
    $('#menu, .pages').live("swipeleft", hide);
    $('.pages').live("swiperight", show);
    $('div[data-role="page"]').live('pagebeforeshow', function (event, ui) {
        menuStatus = false;
        $(".pages").css("margin-left", "0");
    });
    
});