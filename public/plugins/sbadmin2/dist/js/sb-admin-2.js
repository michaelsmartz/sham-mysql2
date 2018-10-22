$(function() {

    $('#side-menu').metisMenu({
        toggle: true,
        preventDefault: false
    });

    $('.prevent-default').on('click', function (event) {
        //event.preventDefault();
    });
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).on("load resize", function() {
        //console.log('load resize');
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height + 600) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

/*
 Help Popup function
 */
function showHelp(pageName){
//alert(pageName);
//this is the popup script for the new window
    var myWindow = window.open(pageName, "tinyWindow", 'scrollbars=yes,menubar=no,height=600,width=700,resizable=1,toolbar=0,menubar=0,location=0,directories=0,channelmode=0,titlebar=no,addressbar=0, status=0');
//this assures the window will come to the front of the current page
    myWindow.focus();
}

/* PREVENT RIGHT CLICK AND COPY PASTE
$(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });

    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});
*/