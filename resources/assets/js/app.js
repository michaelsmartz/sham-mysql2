import Popper from 'popper.js';
import ready from '@benjaminreid/ready.js';
import asyncJS from 'async-js';

import draggable from 'jquery-ui/ui/widgets/draggable';
import droppable from 'jquery-ui/ui/widgets/droppable';
import resizable from 'jquery-ui/ui/widgets/resizable';
import sortable from 'jquery-ui/ui/widgets/sortable';
import datepicker from 'jquery-ui/ui/widgets/datepicker';
import timepicker from 'jquery-ui-timepicker-addon/dist/jquery-ui-timepicker-addon';
import sliderAccess from 'jquery-ui/ui/widgets/slider';
import tab from 'bootstrap/js/dist/tab';

window.$ = window.jQuery = global.$ = global.jQuery = require('jquery');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function specialTitleCaseFormat() {
    //var s = "mcdonald mack macdonald macleod elizabeth mchenry-phipps ramlall";
    var s = $(this).val();
    s = s.replace(/\b(m(a)?c)?(\w)(?=\w)/ig, function($1, $2, $3, $4) {
        return ($2) ? "M" + ($3 || "") + "c" + $4.toUpperCase() : $4.toUpperCase();
    });
    $(this).val(s);
}
function validateDigitQty(e) {
    var key = window.event ? e.keyCode : e.which;
    if (e.keyCode == 8 || e.keyCode == 46 || e.keyCode == 37 || e.keyCode == 39) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else return true;
};

$('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
});
$(function() {
    $("body").delegate("input.datepicker", "focusin", function () {
        if ($(this).attr('id')!='DateOfBirth') {
            $(this).datepicker({ 
                dateFormat:'yy-mm-dd',changeMonth:true, changeYear:true,
                minDate: $(this).data('minDate') || null
            }).prop('readonly', 'true');
        }
    });

    $("body").delegate("input.timepicker", "focusin", function () {
        $(this).timepicker({
            hourGrid: 3,
            minuteGrid: 10,
            timeInput: false,
        }).prop('readonly', 'true');
    });

    $("body").delegate("input.fix-case", "change keyup input", specialTitleCaseFormat);
});
$.fn.clickToggle = function (f1, f2) {
    return this.each(function () {
        var clicked = false;
        $(this).bind('click', function () {
            if (clicked) {
                clicked = false;
                return f2.apply(this, arguments);
            }
            clicked = true;
            return f1.apply(this, arguments);
        });
    });
};

window.validateDigitQty = validateDigitQty;

window.Popper = Popper;
window.Util = require('exports-loader?Util!bootstrap/js/dist/util'); // eslint-disable-line
//window.Button = require('exports-loader?Button!bootstrap/js/dist/button'); // eslint-disable-line
//window.Tooltip = require('exports-loader?Tooltip!bootstrap/js/dist/tooltip'); // eslint-disable-line
//window.Modal = require('exports-loader?Modal!bootstrap/js/dist/modal'); // eslint-disable-line
//window.Popover = require('exports-loader?Tooltip!bootstrap/js/dist/popover'); // eslint-disable-line
window.Dropdown = require('exports-loader?Dropdown!bootstrap/js/dist/dropdown'); // eslint-disable-line
window.Tab = require('exports-loader?Tab!bootstrap/js/dist/tab'); // eslint-disable-line

window.asyncJS = global.asyncJS = asyncJS;