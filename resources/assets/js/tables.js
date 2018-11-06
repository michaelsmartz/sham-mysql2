//import * as jsPDF from 'jspdf';

require("bootstrap-table");
require("tableexport.jquery.plugin");
//window.jsPDF = global.jsPDF = jsPDF;
//require("jspdf-autotable");
require("bootstrap-table/src/extensions/export/bootstrap-table-export");

+function ($) {
    $("#sidebarCollapse").on("click", function() {
        $("#filter-sidebar").toggleClass("active");
        $(this).toggleClass("active");
    });
    $('.search-column-chooser-btn').click(function() {
        $('.search-column-list').slideToggle(100);
    });
    $('.search-column-list li').click(function() {
        var target = $(this).html(),
            filterColumn = $(this).data('filterColumn'),
            toRemove = 'By ',
            newTarget = target.replace(toRemove, '');
        //remove spaces
        newTarget = newTarget.replace(/\s/g, '');
        $(".search-large").html(newTarget);
        $('.search-column-list').hide();
        //newTarget = newTarget.toLowerCase();
        $('.submitable-column-name').prop('name', filterColumn);
    });
    $('.search-input').change(function(){
        $('.submitable-column-name').val($(this).val());
    });
    
    $.extend($.fn.bootstrapTable.columnDefaults, {
          sortable: true
    });
    
    $.extend($.fn.bootstrapTable.defaults, {
        classes: "light-table table-no-bordered table-hover",
        toolbar: "#toolbar",
        buttonsClass: "default",
        showColumns: true,
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            "fileName": '@yield("title")',
            "worksheetName": "test1"/*,
            "jspdf": {
              "autotable": {
                "styles":{"overflow":"linebreak", "columnWidth":"auto", "rowHeight":20, "fontSize":10 },
                "headerStyles": { "fillColor":255, "textColor":0 },
                "alternateRowStyles": { "fillColor":[60, 69, 79], "textColor":255 },
                "addPageContent": "pageContent"
              }
            }*/
        }
    });

    var $table = $('#table');
    $table.on('expand-row.bs.table', function(e, index, row, $detail) {
        $('#table tr[data-index='+index+'] td:first-child a.detail-icon i').attr('data-wenk', 'Hide documents');

        let id = $('#table tr[data-index='+index+']').data('id');
        let url = $('#table tr[data-index='+index+']').data('url');
        let attachUrl = url+'/'+id+'/attachment';
        $detail.html('Loading...');
        $.get(attachUrl).done(function(res) {
            $detail.html(res);
        }).fail(function() {
            $detail.html('Could not load details, please try again...');
        });
    });

    $table.on('collapse-row.bs.table', function(e, index, row) {
        $('#table tr[data-index='+index+'] td:first-child a.detail-icon i').attr('data-wenk', 'Show documents');
    });

    $table.on('post-body.bs.table', function(e, index, row) {
        $('.detail-icon').parent('td').attr('data-html2canvas-ignore', true);
    });

}(jQuery);

$(window).load(function () {
    var $table = $('#table');
    $table.find('tr td:first-child').each(function () {
        $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk', 'Show documents');
        $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk-pos', 'right');
    });
});
