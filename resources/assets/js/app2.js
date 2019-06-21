import {on} from 'delegated-events';
import Popper from 'popper.js';
import asyncJS from 'async-js';

// Need to add base css for flatpickr
import 'flatpickr/dist/flatpickr.min.css';

var EventEmitter = require('events');
var $ = require('jquery');

require('touch-dnd/touch-dnd.js');

var flatpickr = require("flatpickr");
// https://chmln.github.io/flatpickr/plugins/
import ConfirmDatePlugin from 'flatpickr/dist/plugins/confirmDate/confirmDate.js';
import 'flatpickr/dist/plugins/confirmDate/confirmDate.css';

// Override Global settings
flatpickr.setDefaults({
    dateFormat: 'Y-m-d',
    plugins: [new ConfirmDatePlugin({confirmText: 'Done', showAlways:true})]
});
window.flatpickr = flatpickr;

window.specialTitleCaseFormat = function(e) {
    //var s = "mcdonald mack macdonald macleod elizabeth mchenry-phipps";
    var s = $(this).val();
    s = s.replace(/\b(m(a)?c)?(\w)(?=\w)/ig, function($1, $2, $3, $4) {
        return ($2) ? "M" + ($3 || "") + "c" + $4.toUpperCase() : $4.toUpperCase();
    });
    $(this).val(s);
};

window.validateDigitQty = function(e){
    var key = window.event ? e.keyCode : e.which;
    if (e.keyCode == 8 || e.keyCode == 46 || e.keyCode == 37 || e.keyCode == 39) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else return true;
};

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
    });

    $(window).blur(function() {
        var $focused = $(document.activeElement);
        if ($focused.hasClass('picker__holder')) {
            $(document.activeElement).blur();
        }
    });
});

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

$("body").delegate("input.fix-case", "change keyup input", specialTitleCaseFormat);

window.$ = window.jQuery = global.$ = global.jQuery = $;
window.on = global.on = on;

// Listen for browser-generated events.
on('focusin', 'input.datepicker', function(event) {

    var el = $(this),
        val = el.val(),
        toPickerId = $(this).data('pairElementId'),
        elFlatpickr = el._flatpickr;

    var options = {
        defaultDate: val,
        locale: {
            "firstDayOfWeek": 1 // start week on Monday
        }
    }

    if(typeof el._flatpickr === "undefined") {
        elFlatpickr = flatpickr(el, options);
        elFlatpickr.open();
    } else {
        elFlatpickr = flatpickr(el, options);
    }

    if(typeof toPickerId !== "undefined") {
        var toPickerVal = $('#' + toPickerId).val(),
            toPicker = flatpickr('#' + toPickerId, {defaultDate: toPickerVal});

        elFlatpickr.onChange = function(selectedDates, dateStr, instance) {
            toPicker.set('minDate', selectedDates[0]);
        };
        toPicker.onChange = function(selectedDates, dateStr, instance) {
            elFlatpickr.set('maxDate', selectedDates[0]);
        };

    }

});

// make bootstrap js available
window.Popper = Popper;
window.Util = require('exports-loader?Util!bootstrap/js/dist/util'); // eslint-disable-line
window.Dropdown = require('exports-loader?Dropdown!bootstrap/js/dist/dropdown'); // eslint-disable-line
window.Tab = require('exports-loader?Tab!bootstrap/js/dist/tab'); // eslint-disable-line
window.Collapse= require('exports-loader?Collapse!bootstrap/js/dist/collapse'); // eslint-disable-line

window.EventEmitter = global.EventEmitter = EventEmitter;
window.appEe = new EventEmitter();
window.asyncJS = global.asyncJS = asyncJS;