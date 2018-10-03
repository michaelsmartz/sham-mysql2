/*!
 *
 */

/*** jQuery UI Datepicker options ***/
var minDate = 0; // disable past dates
var defaultDate = new Date();

/*** Timepicker options ***/
var hourMin = 7; // minimum selectable hour
var hourMax = 18;  // maximum selectable hour
var stepMinute = 15; // interval in minutes
var timeFormat = 'HH:mm';

/*
var handleSlimScroll = function() {
    "use strict";
    $('[data-scrollbar=true]').each( function() {
        generateSlimScroll($(this));
    });
};
var generateSlimScroll = function(element) {
    var dataHeight = $(element).attr('data-scrollbar-height');
    dataHeight = (!dataHeight) ? $(element).height() : dataHeight;

    var scrollBarOption = {
        //height: dataHeight,
        size: '4px',
        position: 'left'
    };
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $(element).css('height', dataHeight);
        $(element).css('overflow-x','scroll');
    } else {
        $(element).slimScroll(scrollBarOption);
    }
};
*/

/**
 * Get the value of a querystring
 * @param  {String} field The field to get the value of
 * @param  {String} url   The URL to get the value from (optional)
 * @return {String}       The field value
 */
var getQueryString = function ( field, url ) {
    var href = url ? url : window.location.href;
    var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
    var string = reg.exec(href);
    return string ? string[1] : null;
};


function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

function setButtonBusy(selector, busyVal) {
    // true by default if parameter omitted
    if (typeof(busyVal)==='undefined') busyVal = true;

    var busyLockSelectors = $(selector).data('busy-connector');
    $(selector).attr('data-busy', busyVal);
    if (busyVal) {
        $(selector).addClass('faded');
        if(busyLockSelectors !='') {
            $(busyLockSelectors).addClass('faded');
        }
    } else {
        if(busyLockSelectors !='') {
            $(busyLockSelectors).removeClass('faded');
        }
        $(selector).removeClass('faded');
    }
}

function setAutoTooltips() {
    $("[data-toggle='tooltip']").tooltip({container: "body", html:true});
}

function titleCaseFormat() {
    var str = $(this).val();
    str = str.toLowerCase().replace(/([^a-z])([a-z])(?=[a-z]{2})|^([a-z])/g, function(_, g1, g2, g3) {
        return (typeof g1 === 'undefined') ? g3.toUpperCase() : g1 + g2.toUpperCase();
    });
    $(this).val(str);
}

function contentToModalDialogLoader(url) {

    // example url: '{{URL::to("shamusers")}}/{{ (Auth::user()!=null)?Auth::user()->Id:0}}/edit'
    $('#md-content').empty();
    $('#md').modal('toggle');
    $('#md-content').load(url,function(response, status, xhr) {
        /*if (status == "success") {*/
            $('#md').modal('show');
            //return false;
        /*}
        else {
            $('#mde').modal('show');
        }*/
    });
    //return true;
}

function setDefaultDatepickerOptions() {
    $.datepicker.setDefaults({
        dateFormat:'yy-mm-dd',
        changeYear: true,
        changeMonth:true,
        showOn: "focus"
    });
}

function setDatePickers() {
    $(".datepicker").datepicker({
        dateFormat:'yy-mm-dd', changeYear:true, showOn:"focus",
        onClose: function() {
            $(this).trigger("focus").trigger("blur");
            $(this).valid();

            var validator = $(this).closest('form').data("validator");
            if (validator) {
                $(this).valid();
            }
        }
    }).prop('readonly', 'true');

    $(".datepicker").each(function() {
        $(this).datepicker('setDate', $(this).val());
    });
}

var limitNumberInput = function () {
    var value = parseInt(this.value, 10);
    var max = parseInt(this.max, 10);
    var min = parseInt(this.min, 10);

    if (value > max) {
        this.value = max;
    } else if (value < min) {
        this.value = min
    }
};

if (typeof($) !== 'undefined' && typeof($.validator) !== 'undefined') {
    /*** jQuery validator custom rules and classes ***/
// add jQuery validator class rules and methods here
    $.validator.addMethod("valueNotEquals", function(value, element, arg){
        return this.optional(element) || arg != value;
    }, "Value must not equal arg.");

    $.validator.addMethod("minage", function(value, element, argument){
        var age = moment(value);
        var now = moment();
        return this.optional(element) || now.diff(age,'years') >= argument;
    }, jQuery.validator.format("Date must be at least {0} years ago."));

    $.validator.addMethod("noSpace", function(value, element) {
        return this.optional(element) || (value.indexOf(" ") < 0 && value != "");
    }, "No space please and don't leave it empty");

    $.validator.addMethod("dependsOnFieldNotEmpty", function(value, element, argument){
        var argVal;
        var elm = document.getElementById(argument);
        var argType = $(elm).prop('type');

        if (argType == 'select-one') {
            argVal = $('select#' + argument + ' option:selected').val();
        } else {
            argVal = $('input[name=' + argument + ']').val();
        }

        // we don't check element is optional, instead we only check the value
        return (argVal == '') || (argVal != '' && value != '');

    }, "This field is required.");

    $.validator.addClassRules("field-required", { required: true });
    $.validator.addClassRules("field-digits", { digits: true });
    $.validator.addClassRules("field-email", { email: true });

    /*** jQuery validator custom messages
     * Alloy UI message style ***/
    $.validator.messages.required = function(param, input) {
        var txt;
        if ($(input).attr('placeholder')) {
            txt = $(input).attr('placeholder');
        } else {
            if ($(input).attr('data-field-name')) {
                txt = $(input).attr('data-field-name');
            } else txt = 'This field';
        }

        return txt + ' is required';
    };

    $.validator.messages.minlength = function(param, input) {
        return 'Please enter at least ' + param + ' characters for ' + input.name;
    };

    $.validator.messages.maxlength = function(param, input) {
        return 'Please enter a maximum of ' + param + ' characters for ' + input.name;
    };

    /*** jQuery validator defaults ***/
    $.validator.setDefaults({
        onfocusout: function(element) {
            this.element(element);
        },
        invalidHandler: function(event, validator) {
            // 'this' refers to the form
            var errors = validator.numberOfInvalids();
            if (errors>0) {
                var message = 'You missed '+ errors +' or more field(s). Please check the highlighted tabs.';
                $("div.error label").html(message).show();
            } else {
                $("div.error label").html('');
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
            var tabContainerId = $(element).closest('div.tab-pane').prop('id');
            if (typeof tabContainerId!=='undefined') {
                var tabLink = $('[href="#' + tabContainerId + '"]');
                $(tabLink).addClass('error');
            }

        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
            var tabContainerId = $(element).closest('div.tab-pane').prop('id');
            if (tabContainerId!=undefined) {
                var tabLink = $('[href="#' + tabContainerId + '"]');
            }
        },
        errorElement: 'strong',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            var rc = $(element).parents('.row-container'),
                er = $(rc).find('.errors');
            //console.log(rc, er);
            if (rc.length > 0) {
                error.appendTo(er);
                $(error).position({
                    my: "bottom",
                    at: "bottom + 15px",
                    of: $(element)});
                $(error).offset({top:0});
            } else {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }

        },
        submitHandler: function(form) {
            // trigger custom event before submitting valid form
            var validator = this;
            var event = $.Event("preSubmitValidFormData");
            event.form = form;
            event.validator = validator; // validator instance
            $.event.trigger(event);

            if ( !event.isDefaultPrevented() ) {
                // Perform an action...
                // do other things for a valid form
                //$('.has-spinner',form).removeClass('btn-primary').addClass('btn-default');
                $(form).find(":button").attr('disabled', 'true');
                $(form).find(":submit").attr('disabled', 'true').val('Please wait..');
                form.submit();
            }
        }
    });
}