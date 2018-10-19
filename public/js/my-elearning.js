/**
 * Created by TaroonG on 2016-11-29.
 */

$(window).resize(function () {
    $.each($('.metro-tile-page:not(.active)'), function () {
        $(this).css('right', ($(this).width() + 30) * -1);
    });
});
$(document).ready(function () {

    // set up jQuery with the CSRF token, or else post routes will fail
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $("#CourseId").change(function() {
        var v = $(this).val();
        if (v=='') {
            $('#discussionPreview').css('display','none');
        } else {
            $('#discussionPreview').css('display','block');
        }
    });

    $(".overflow-container").niceScroll({
        cursorborder:"3",
        cursorcolor:"#fff",
        cursorwidth:"4px",
        horizrailenabled: !1,
        mousescrollstep: "20"
    });

    $.each($(".metro-tile-page"), function (index, tile) {
        $.each($(tile).children('img'), function (ind, img) {
            $(tile).css('background-image', 'url(' + $(img).attr('src') + ')');
            $(img).hide();
        });
    });
    $.each($('.metro-tile-page:not(.active)'), function () {
        $(this).css('right', ($(this).width() + 30) * -1);
    });

    $('.enrol').click(function() {
        var el = $(this);
        if (el.attr('data-busy')) {
            return;
        }
        el.attr('data-busy', 'true').text('Please wait');
        var request = $.ajax({
            url: 'my-elearning/enrol',
            type: "POST",
            data: {
                'id': el.attr('data-id')
            },
            dataType: "json"
        });

        request.done(function (msg) {
            $.amaran({
                'content'   :{
                    title: 'My E-learning',
                    message: 'You have been enrolled successfully',
                    info: '',
                    icon: 'fa fa-check'
                },
                'delay': 5500, // 5.5 seconds
                'closeButton': true,
                'position': 'top right'
            });
            el.parent().addClass('hide');
            //reload iframe
            $('#myCoursesFrame')[0].contentWindow.location.reload(true);
        });

        request.fail(function (jqXHR, textStatus) {
            el.attr('data-busy', 'false').text('Enrol on this course');
            $.amaran({
                'content'   :{
                    title: 'My E-learning',
                    message: 'An error has occurred while trying to enrol. Please retry!',
                    info: '',
                    icon: 'fa fa-close',
                    bgcolor: '000',
                    color: 'red'
                },
                'delay': 5500, // 5.5 seconds
                'closeButton': true,
                'position': 'top right'
            });
        });
    });

});
