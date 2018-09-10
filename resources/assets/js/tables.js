import * as jsPDF from 'jspdf';

require("bootstrap-table");
require("tableexport.jquery.plugin");
window.jsPDF = global.jsPDF = jsPDF;
require("jspdf-autotable");
require("bootstrap-table/src/extensions/export/bootstrap-table-export");

+function ($) {
    $("#sidebarCollapse").on("click", function() {
        $("#filter-sidebar").toggleClass("active");
        $(this).toggleClass("active");
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
        exportTypes: ['excel', 'csv', 'pdf'],
        exportOptions: {
            "fileName": '@yield("title")',
            "worksheetName": "test1",
            "jspdf": {
              "autotable": {
                "styles":{"overflow":"linebreak", "columnWidth":"auto", "rowHeight":20, "fontSize":10 },
                "headerStyles": { "fillColor":255, "textColor":0 },
                "alternateRowStyles": { "fillColor":[60, 69, 79], "textColor":255 },
                "addPageContent": "pageContent"
              }
            }
        }
    });

    var $table = $('#table');
    $table.on('expand-row.bs.table', function(e, index, row, $detail) {
        // console.log(index, row, $detail);
        $('#table tr[data-index='+index+'] td:first-child a.detail-icon i').attr('data-wenk', 'Hide documents');

        let id = $('#table tr[data-index='+index+']').data('id');
        let url = $('#table tr[data-index='+index+']').data('url');
        let attachUrl = url+'/'+id+'/attachment';
        $detail.html('Loading...');
        $.get(attachUrl, function (res) {
            $detail.html(res);
        });
    });

    $table.on('collapse-row.bs.table', function(e, index, row) {
        $('#table tr[data-index='+index+'] td:first-child a.detail-icon i').attr('data-wenk', 'Show documents');
    });

}(jQuery);

$(window).load(function () {
    var $table = $('#table');
    $table.find('tr td:first-child').each(function () {
        //console.log($(this).children('a.detail-icon'));
        $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk', 'Show documents');
        $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk-pos', 'right');
    });
});
