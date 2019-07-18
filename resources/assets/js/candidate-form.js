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