import {on} from "delegated-events";

window.on = global.on = on;

on('keyup','#search-team',function(event){
    var str = $('#search-team').val();
    $('.my-team').hide();
    $( ".my-team" ).each(function(index) {
        if($(this).attr('data-team').toLowerCase().search( str.toLowerCase() ) !== -1){
            $(this).show();
        }
    });
});

on('click','#reset-search',function(event){
    $('#search-team').val('');
    $('.my-team').show();
});