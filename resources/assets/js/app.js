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
import collapse from 'bootstrap/js/dist/collapse';

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
    $.datepicker.setDefaults({
        showButtonPanel: true,
        dateFormat:'yy-mm-dd', changeMonth:true, changeYear:true 
    });
    $("body").delegate("input.datepicker", "focusin", function () {
        if ($(this).attr('id')!='DateOfBirth') {
            var elem = $(this); 
            var instnce = jQuery.datepicker._getInst(elem[0]);

            if (typeof instnce == 'undefined') {
                elem.datepicker({ 
                    minDate: $(this).data('minDate') || null,
                    numberOfMonths: $(this).data('numberOfMonths') || 1,
                    beforeShow: function(input, inst)
                    {
                        setTimeout(function() { 
                            $('.ui-datepicker-clear').bind('click', function() { $(input).val(''); });
                        }, 0);
                    },
                    onSelect: function(dateStr) 
                    {
                        var target = $(this).data('pairElementId');

                        if(typeof target != 'undefined') {
                            $(`#${target}`).val(dateStr);
                        }
                    },
                    onClose: function()
                    {
                        var d1 = $(this).datepicker("getDate"),
                            targetId = $(this).data('pairElementId');

                        if(typeof targetId != 'undefined') {
                            var targetElem = $(`#${targetId}`); 
                            var targetInstnce = jQuery.datepicker._getInst(targetElem[0]);

                            d1.setDate(d1.getDate() + 0); // change to + 1 if necessary
                            if(typeof targetInstnce == 'undefined'){
                                targetElem.datepicker({minDate: d1});
                            } else {
                                targetElem.datepicker("option", "minDate", d1).datepicker("refresh");
                            }
                        }
                    }
                }).prop('readonly', 'true').keyup(function (e) {
                    if(e.keyCode == 8 || e.keyCode == 46) {
                        $.datepicker._clearDate(this);
                    }
                });
            }
        }
    });

    $("body").delegate("input.timepicker", "focusin", function () {
        $(this).timepicker({
            hourGrid: 3, minuteGrid: 10, timeInput: false
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
window.Collapse= require('exports-loader?Collapse!bootstrap/js/dist/collapse'); // eslint-disable-line

window.asyncJS = global.asyncJS = asyncJS;