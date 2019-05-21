$( document ).ready(function() {
    $('.pending_box').on('change',function(){
        if(this.checked) {
            var checked =  $('#leave_list').val() + $(this).val() + ',';
            $('#leave_list').val(checked);
        }else{
            var unchecked = $('#leave_list').val()
            $('#leave_list').val(unchecked.replace($(this).val() + ',',''));
        }
       
    });

    $('#bundle_submit').on('click',function(){
        var leave_ids = $('#leave_list').val().slice(0,-1);
        var status = $('#batch_operation').find(":selected").val();
        
        window.location = "/leaves/batch/"+leave_ids+"/"+status;
       
    });
});


function filter() {
    filter_date();
    filter_absence_type();
}

function filter_date(){
    var from = $("#from").val();
    var to   = $("#to").val();

    $("#table-leaves tr.data-history").each(function() {
        var row = $(this);
        var date = row.find("td").eq(1).text();
        var show = true;


        if (from && date < from)
            show = false;

        if (to && date > to)
            show = false;

        if (show)
            row.show();
        else
            row.hide();
    });

}

function filter_absence_type(){
    var type = $("#absence_type").val();

    $("#table-leaves tr.data-history").each(function() {
        var row = $(this);
        var absence = row.find("td").eq(0).text();
        var show = true;

        if ((absence !== type) && (type !== '0')){
            show = false;
        }else{
            show = true;
        }

        if (show)
            row.show();
        else
            row.hide();
    });

}
