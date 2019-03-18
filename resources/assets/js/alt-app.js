import {on} from 'delegated-events';
import Popper from 'popper.js';
import asyncJS from 'async-js';

window.$ = window.jQuery = global.$ = global.jQuery = require('jquery');
require('touch-dnd/touch-dnd.js');
require('picker');
require('pickadate/lib/picker.date.js');
window.on = global.on = on;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function specialTitleCaseFormat() {
    //var s = "mcdonald mack macdonald macleod elizabeth mchenry-phipps";
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

$.fn.mirror = function (selector) {
    return this.each(function () {
        var $this = $(this);
        var $selector = $(selector);
        $this.bind('keyup change', function () {
            $selector.val($this.val());
        });
    });
};

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

$(function(){
    $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
    });
    // Extend the default picker options for all instances.
    $.extend($.fn.pickadate.defaults, {
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        selectYears: 20,
        selectMonths: true,
        closeOnSelect: true,
        container: '#date-picker'
    });

    $(window).blur(function() {
        var $focused = $(document.activeElement);
        if ($focused.hasClass('picker__holder')) {
            $(document.activeElement).blur();
        }
    });
});

// Listen for browser-generated events.
on('focusin', 'input.datepicker', function(event) {

    // Use the picker object directly.
    var picker = $(this).pickadate('picker'),
        toPickerId = $(this).data('pairElementId'),
        toPicker = $(`#${toPickerId}`).pickadate('picker');

    if(picker === undefined) {

        if($(this).attr('id') == 'birth_date'){
            picker = $("#birth_date").pickadate({min: -65*365, max:-18*365}).pickadate('picker');
        } else {
            picker = $(this).pickadate().pickadate('picker');
        }
    }

    if(toPickerId !== undefined){

        toPicker = $(`#${toPickerId}`).pickadate().pickadate('picker');

        if(toPicker !== undefined){
            // When something is selected, update the “from” and “to” limits.
            picker.on('set', function(event) {
                if ( event.select ) {
                    toPicker.set('min', picker.get('select'));
                }
                else if ( 'clear' in event ) {
                    toPicker.set('min', false);
                }
            });
            toPicker.on('set', function(event) {
                if ( event.select ) {
                    picker.set('max', toPicker.get('select'));
                }
                else if ( 'clear' in event ) {
                    picker.set('max', false);
                }
            });
            
            // Check if there’s a “from” or “to” date to start with.
            if ( picker.get('value') ) {
                toPicker.set('min', picker.get('select'));
            }
            if ( toPicker.get('value') ) {
                picker.set('max', toPicker.get('select'));
            }
        }

    }

});
on('change keyup input', 'input.fix-case', specialTitleCaseFormat);

window.validateDigitQty = validateDigitQty;

window.Popper = Popper;
window.Util = require('exports-loader?Util!bootstrap/js/dist/util'); // eslint-disable-line
window.Dropdown = require('exports-loader?Dropdown!bootstrap/js/dist/dropdown'); // eslint-disable-line
window.Tab = require('exports-loader?Tab!bootstrap/js/dist/tab'); // eslint-disable-line
window.Collapse= require('exports-loader?Collapse!bootstrap/js/dist/collapse'); // eslint-disable-line

window.asyncJS = global.asyncJS = asyncJS;