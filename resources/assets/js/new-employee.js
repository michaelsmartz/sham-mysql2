require('touch-dnd/touch-dnd.js');
//require('jquery-asAccordion');
require('pickadate/lib/picker');
require('sumoselect');

// Extend the default picker options for all instances.
$.extend($.fn.pickadate.defaults, {
    format: 'yyyy-mm-dd',
    formatSubmit: 'yyyy-mm-dd',
    selectYears: true,
    selectMonths: true
});

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

            $("#birth_date").datepicker("option","yearRange", "-65:-18");
            
            //$('.accordion').asAccordion();
            $('.select-multiple').SumoSelect({csvDispCount: 10, up:true});

            $(document).on('change', '.datepicker', function () { //use this line if you create datepickers dynamically
                if ($(this).data('datepicker_from_or_to') === 'from') {
                    $('#'+$(this).data('datepicker_to_target')).pickadate('picker').set('min',$(this).val());
                }
                if ($(this).data('datepicker_from_or_to') === 'to') {
                    $('#'+$(this).data('datepicker_from_target')).pickadate('picker').set('max',$(this).val());
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
            fetch('./qualifications')
            .then(res => res.json())
            .then(res => {
                this.quals = res;
            })
        }
    },
    created: function()
    {
        this.fetchQualifications();
    }
});