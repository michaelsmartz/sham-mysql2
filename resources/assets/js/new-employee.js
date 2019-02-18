import {on} from 'delegated-events';

require('touch-dnd/touch-dnd.js');
require('jquery-asAccordion');

require('picker');
require('pickadate/lib/picker.date.js');
require('parsleyjs');
require('sumoselect');

window.Vue = require('vue/dist/vue.common.js');

Vue.config.devtools = false;
Vue.config.performance = false;

export function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

const app = new Vue({
    el: '#accordion-app',
    data: {
        qual: {
            reference: '', description: '', institution: '', obtained_on: '',
            student_no: ''
        },
        quals: []
    },
    mounted: function () {
        +function ($, el) {
            
            // Extend the default picker options for all instances.
            $.extend($.fn.pickadate.defaults, {
                format: 'yyyy-mm-dd',
                formatSubmit: 'yyyy-mm-dd',
                selectYears: 20,
                selectMonths: true,
                closeOnSelect: true,
                container: '#date-picker'
            });

            // Listen for browser-generated events.
            on('focusin', 'input.datepicker', function(event) {
                // Use the picker object directly.
                var picker = $(this).pickadate('picker');
                if(picker === undefined){
                    //$(this).pickadate();
                }
            });

            $("#imageUpload").change(function() {
                readURL(this);
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

            //$("#birth_date").pickadate({min: -65*365, max:-18*365});
            
            $('.accordion').asAccordion();
            $('.select-multiple').SumoSelect({csvDispCount: 10, up:true});

            window.Parsley.addValidator('requiredIf', {
                validateString: function (value, requirement) {
                    if (jQuery(requirement).val()) {
                        return !!value;
                    }
                    return true;
                }, priority: 33
            });
            window.Parsley.addValidator('fileextension', function (value, requirement) {
                var fileExtension = value.split('.').pop();
                return fileExtension === requirement;
            }, 32)
            .addMessage('en', 'fileextension', 'The extension doesn\'t match the required');

            window.Parsley.addValidator('filemaxmegabytes', {
                requirementType: 'string',
                validateString: function (value, requirement, parsleyInstance) {
                    if (!app.utils.formDataSuppoerted) {
                        return true;
                    }
                    var file = parsleyInstance.$element[0].files;
                    var maxBytes = requirement * 1048576;
    
                    if (file.length == 0) {
                        return true;
                    }
                    return file.length === 1 && file[0].size <= maxBytes;
    
                },
                messages: {
                    en: 'File is too big'
                }
            })
            .addValidator('filemimetypes', {
                requirementType: 'string',
                validateString: function (value, requirement, parsleyInstance) {
                    if (!app.utils.formDataSuppoerted) {
                        return true;
                    }
                    var file = parsleyInstance.$element[0].files;
    
                    if (file.length == 0) {
                        return true;
                    }
                    var allowedMimeTypes = requirement.replace(/\s/g, "").split(',');
                    return allowedMimeTypes.indexOf(file[0].type) !== -1;
                },
                messages: {
                    en: 'File mime type not allowed'
                }
            });

            window.Parsley.addAsyncValidator('checkId',
                function(xhr) {
                    return xhr.responseText !== 'false';
                }, './check-id'
            );
            window.Parsley.addAsyncValidator('checkName',
                function(xhr) {
                    return xhr.responseText !== 'false';
                }, './check-name'
            );
            window.Parsley.addAsyncValidator('checkPassport',
                function(xhr) {
                    return xhr.responseText !== 'false';
                }, './check-passport'
            );
            window.Parsley.addAsyncValidator('checkEmployeeNo',
                function(xhr) {
                    return xhr.responseText !== 'false';
                }, './check-employeeno'
            );
            window.Parsley.on('field:ajaxoptions', function(p1,ajaxOptions) {
                var FirstName = $("[name=first_name]").val(),
                    Surname = $("[name=surname]").val(),
                    IdNumber = $("[name=id_number]").val(),
                    PassportCountryId = $("[name=passport_country_id]").val(),
                    PassportNo = $("[name=passport_no]").val(),
                    EmployeeNo = $("[name=employee_no]").val();
    
                var namedDataMap = {
                  'id_number': { 'idNumber':IdNumber,'firstName':FirstName,'surname':Surname},
                  'employee_no': { 'employeeNo':EmployeeNo},
                  'passport_no': { 'passportCountryId':PassportCountryId,'passportNo':PassportNo,'firstName':FirstName,'surname':Surname},
                };
    
                ajaxOptions.global = false;
                ajaxOptions.data = namedDataMap[$(this.$element[0]).attr('name')];
            });


            $(document).on('change', '.datepicker', function () { //use this line if you create datepickers dynamically
                if ($(this).data('datepicker_from_or_to') === 'from') {
                    $('#'+$(this).data('datepicker_to_target')).pickadate('picker').set('min', $(this).val());
                }
                if ($(this).data('datepicker_from_or_to') === 'to') {
                    $('#'+$(this).data('datepicker_from_target')).pickadate('picker').set('max', $(this).val());
                }
            });
            
            $(':input[data-mirror]').each(function () {
                $(this).mirror($(this).data('mirror'));
            });

        }(jQuery, this);
    },
    methods: {
        addNewQual: function () {
            this.quals.push(Vue.util.extend({}, this.qual));
            //ensure height is enough as accordion sets a height as inline style
            $('.accordion--active').css("height", "");
        },
        removeQual: function (index) {
            Vue.delete(this.quals, index);
        },
        submitForm: function (event) {
            event.preventDefault();
        },
        fetchQualifications: function()
        {
            let fetchData = {
                method: 'GET',
                headers: new Headers({
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                })
            };

            if (!route().current("employees.create")) {
                fetch('./qualifications', fetchData)
                .then(res => res.json())
                .then(res => {
                    this.quals = res;
                });
            }

        }
    },
    created: function()
    {
        this.fetchQualifications();
    }
});