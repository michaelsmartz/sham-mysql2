import {on} from "delegated-events";

window.on = global.on = on;

// Listen for browser-generated events.
on('change', '#eligibility_ends', function(event) {
    hideAccruePeriod();
});

// Listen for browser-generated events.
on('change', '#eligibility_begins', function(event) {
    eligibility_error();
});

function hideAccruePeriod(){
    if ($("#eligibility_ends").val() === "1") {
        $("#accrue_period").hide()
    } else {
        $("#accrue_period").show()
    }
}

function eligibility_error(){
    if ($("#eligibility_begins").val() === "1") {
        $("#eligibility_ends option[value='1']").hide();
        $('#eligibility_ends>option:eq(0)').prop('selected', true);
        $("#accrue_period").show();
    }else{
        $("#eligibility_ends option[value='1']").show();
    }
}