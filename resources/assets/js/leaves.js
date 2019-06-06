import {on} from "delegated-events";

window.on = global.on = on;
$("input[name='_method']").val('POST');

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

on('click','#bundle_check',function(event){
    $('.pending_box').trigger('click');
});

on('click','#btn-leave-apply',function(event){
    if(($("#leave_from").val() === "") || ($("#leave_to").val() === "")){
        event.preventDefault();
    }
});

// Listen for browser-generated events.
on('focusin', 'input.datepicker-leave', function(event) {
    var el = $(this),
        val = el.val(),
        elFlatpickr = el._flatpickr;

    var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']
    var disable_date = new Array();
    var time_slot    = new Array();
    var non_working  = $('#non_working').val();

    $.each(days, function( index, value ) {
        if($('#'+value).length){
            time_slot[index] = $('#'+value).val().split('-');
        }else{
            if(non_working !== '0'){
                var default_time = "08:00-17:00";
                time_slot[index] = default_time.split('-');
            }else{
                disable_date.push(index);
            }
        }
    });


    if(typeof el._flatpickr === "undefined") {
        elFlatpickr = flatpickr(el, {
            defaultDate: val,
            time_24hr: true,
            disable: [function(date) {
                var day = date.getDay();
                if(($.inArray(day,disable_date) !== -1) && (non_working === '0')){
                    return true;
                }
            }],
            locale: {
                "firstDayOfWeek": 1 // start week on Monday
            },
            onChange: function(selectedDates, dateStr, instance) {
                elFlatpickr.set('minTime', time_slot[selectedDates[0].getDay()][0]); //minTime
                elFlatpickr.set('maxTime', time_slot[selectedDates[0].getDay()][1]); //maxTime
            }
    
        });
        elFlatpickr.open();
    } else {
        elFlatpickr = flatpickr(el, {defaultDate: val});
    }

    

});