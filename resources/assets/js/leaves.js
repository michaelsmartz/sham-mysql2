import {on} from "delegated-events";

window.on = global.on = on;

on('change','.pending_box',function(event){
    if(this.checked) {
        var checked =  $('#leave_list').val() + $(this).val() + ',';
        $('#leave_list').val(checked);
    }else{
        var unchecked = $('#leave_list').val()
        $('#leave_list').val(unchecked.replace($(this).val() + ',',''));
    }
       
});

on('click','#bundle_submit',function(event){
        var leave_ids = $('#leave_list').val().slice(0,-1);
        var status = $('#batch_operation').find(":selected").val();
        
        window.location = "/leaves/batch/"+leave_ids+"/"+status;
});


// Listen for browser-generated events.
on('focusin', 'input.datepicker-leave', function(event) {
    var el = $(this),
        val = el.val(),
        elFlatpickr = el._flatpickr;

    var days = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday']
    var disable_date = new Array();
    var time_slot    = new Array();
   

    $.each(days, function( index, value ) {
        if($('#'+value).length){
            time_slot[index] = $('#'+value).val().split('-');
        }else{
            disable_date.push(index);
        }
    });


    if(typeof el._flatpickr === "undefined") {
        elFlatpickr = flatpickr(el, {
            defaultDate: val,
            disable: [function(date) {
                var day = date.getDay();
                if($.inArray(day,disable_date) !== -1){
                    return true;
                }
    
            }],
            locale: {
                "firstDayOfWeek": 1 // start week on Monday
            },
            onChange: function(selectedDates, dateStr, instance) {
                console.log(selectedDates[0].getDay());
                elFlatpickr.set('minTime', time_slot[selectedDates[0].getDay()][0]); //minTime
                elFlatpickr.set('maxTime', time_slot[selectedDates[0].getDay()][1]); //maxTime
            }
    
        });
        elFlatpickr.open();
    } else {
        elFlatpickr = flatpickr(el, {
            defaultDate: val,
            disable: [function(date) {
                var day = date.getDay();
                if($.inArray(day,disable_date) !== -1){
                    return true;
                }
    
            }],
            locale: {
                "firstDayOfWeek": 1 // start week on Monday
            },
            onChange: function(selectedDates, dateStr, instance) {
                console.log(selectedDates[0].getDay());
                elFlatpickr.set('minTime', '8:00');
                elFlatpickr.set('maxTime', '11:00');
            }
    
        });
    }

    

});