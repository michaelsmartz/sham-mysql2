$( document ).ready(function() {

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


window.addForm = function(event, baseUrl) {
    var route;
    if (baseUrl === void 0) {
        route = '<?php echo e(url()->current()); ?>/';
    } else {
        route = '<?php echo e(URL::to('/')); ?>/' + baseUrl + '/';
    }

    loadUrl(route + 'create');
};