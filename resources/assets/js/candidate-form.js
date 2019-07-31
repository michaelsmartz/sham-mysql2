import {on} from "delegated-events";

window.on = global.on = on;

on('click','#nav-personal',function(event){
    $('.candidate_section').hide();
    $('#personal').show()

});

on('click','#nav-qualification',function(event){
    $('.candidate_section').hide();
    $('#qualification').show()

});

on('click','#nav-motivation',function(event){
    $('.candidate_section').hide();
    $('#motivation').show()

});

on('click','#candidate_submit',function(event){
    if(($("#personal").find('li.parsley-required').length === 0) && ($("#motivation").find('li.parsley-required').length !== 0)){
        $('.candidate_section').hide();
        $('#motivation').show()
        $('#nav-personal').removeClass('active');
        $('#nav-motivation').addClass('active');
    }else if(($("#personal").find('li.parsley-required').length !== 0) && ($("#motivation").find('li.parsley-required').length === 0)){
        $('.candidate_section').hide();
        $('#personal').show()
        $('#nav-personal').addClass('active');
        $('#nav-motivation').removeClass('active')
    }
});