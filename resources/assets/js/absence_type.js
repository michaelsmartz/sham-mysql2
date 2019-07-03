import {on} from "delegated-events";

import '../../../node_modules/@simonwep/pickr/dist/themes/nano.min.css'; // 'nano' theme
import Pickr from '../../../node_modules/@simonwep/pickr/dist/pickr.es5.min.js';

require('sumoselect');

window.on = global.on = on;
window.Pickr = global.Pickr = Pickr;

// Listen for browser-generated events.
on('change', '#eligibility_ends', function(event) {
    hideAccruePeriod();
});

// Listen for browser-generated events.
on('change', '#eligibility_begins', function(event) {
    eligibility_ends_error();
});

on('change', '#eligibility_ends', function(event) {
    eligibility_begins_error();
});

window.appEe.on('loadUrl', function(text){
    $('.select-multiple').SumoSelect({csvDispCount: 10, up: true});
});

function hideAccruePeriod(){
    if ($("#eligibility_ends").val() === "1") {
        $("#accrue_period").hide()
    } else {
        $("#accrue_period").show()
    }
}

function eligibility_ends_error(){
    if ($("#eligibility_begins").val() === "1") {
        $("#eligibility_ends option[value='1']").hide();
        $('#eligibility_ends>option:eq(0)').prop('selected', true);
        $("#accrue_period").show();
    }else{
        $("#eligibility_ends option[value='1']").show();
    }
}

function eligibility_begins_error(){
    if ($("#eligibility_ends").val() === "1") {
        $("#eligibility_begins option[value='1']").hide();
        $('#eligibility_begins>option:eq(0)').prop('selected', true);
    }else{
        $("#eligibility_begins option[value='1']").show();
    }
}

