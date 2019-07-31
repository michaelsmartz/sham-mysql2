window.Vue = require('vue/dist/vue.common.js');
window.Vue = require('vue-tables-2/dist/vue-tables-2.min.js');

require('sumoselect');
require('parsleyjs');

import Vue from 'vue'
import Vuex from 'vuex'
import {ClientTable, Event} from 'vue-tables-2';

Vue.config.productionTip = false;
Vue.config.devtools = false;
Vue.config.performance = false;

Vue.use(ClientTable);
Vue.use(Event);
Vue.use(Vuex);

function readURL(input) {
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

if(document.getElementById("candidates-app")) {
    const rr = new Vue({
        el: '#candidates-app',
        data: {
            qual: {
                reference: '', description: '', institution: '', obtained_on: '',
                student_no: ''
            },
            quals: [],
            employment: {
                previous_employer: '', position: '', salary: '',
                reason_leaving: '', start_date: '', end_date: '', contact: ''
            },
            employments: [],
            errors: [],
            titles: [
                'Mr',
                'Miss',
                'Mrs'
            ],
            genders: [
                'Male',
                'Female'
            ],
            maritalStatuses: [
                'married',
                'single',
                'divorced'
            ],
            surname: null,
            firstName: null,
            dob: null,
            personalEmail: null,
            homeAddress: null,
            phone: null,
            position_applied: null,
            date_available: null,
            salary_expectation: null,
            idNumber: null,
            skills: [
                'php',
                'css',
                'mysql',
                'js',
                'angular',
                'vue',
                'laravel',
                'symfony',
                'codeigniter',
                'zend'
            ],
            multipleSelectionsDisabilities: [
                "Optic Atropy",
                "Full Blown Aids"
            ],
            disabilities: [
                "Optic Atropy",
                "Full Blown Aids",
                "Tinnitus",
                "ADHD",
                "Down syndrome",
                "Dyslexia"
            ],
            qualifications: [
                "Higher School Certificate",
                "Certificate",
                "Diploma",
                "Degree",
                "Masters",
                "PhD",
            ],
            selectedTitle: null,
            selectedGender: null,
            selectedMaritalStatus: null,
            selectedDisability: null,
            selectedSkill: null,
            selectedQualification: null,
        },
        methods: {
            checkForm: function (e) {
                if (this.title && this.gender && this.maritalStatus) {
                    return true;
                }

                this.errors = [];

                if (this.surname) {
                    this.errors.push('Surname is required.');
                }

                if (this.firstName) {
                    this.errors.push('FirstName is required.');
                }

                if (!this.selectedDisability) {
                    this.errors.push('Disability is required.');
                }

                if (!this.selectedGender) {
                    this.errors.push('Gender is required.');
                }

                if (!this.selectedTitle) {
                    this.errors.push('Title is required.');
                }

                if (!this.selectedMaritalStatus) {
                    this.errors.push('Marital Status is required.');
                }

                if (!this.dob) {
                    this.errors.push('Date of birth is required.');
                }

                if (!this.selectedSkill) {
                    this.errors.push('Skills is required.');
                }

                e.preventDefault();
            },
            selectedDisabilityFunc: function () {
                console.log(this.selectedDisability)
            },
            selectedSkillFunc: function () {
                console.log(this.selectedSkill)
            },
            selectedQualificationFunc: function () {
                console.log(this.selectedQualification)
            },
            addNewQual: function () {
                this.quals.push(Vue.util.extend({}, this.qual));
                //ensure height is enough as accordion sets a height as inline style
                $('.accordion--active').css("height", "");
            },
            removeQual: function (index) {
                Vue.delete(this.quals, index);
            },
            addNewEmploy: function () {
                this.employments.push(Vue.util.extend({}, this.employment));
                //ensure height is enough as accordion sets a height as inline style
                $('.accordion--active').css("height", "");
            },
            removeEmploy: function (index) {
                Vue.delete(this.employments, index);
            },
            submitForm: function (event) {
                event.preventDefault();
            },
            fetchQualifications: function () {

                if (route().current("candidate.auth.details")) {
                    var id = document.getElementById("candidate_id").value;
                    fetch('/candidates/'+id+'/candidate-qualifications')
                        .then(res => res.json())
                        .then(res => {
                            this.quals = res;
                        })
                }else if (!route().current("candidates.create")) {
                fetch('./candidate-qualifications')
                    .then(res => res.json())
                    .then(res => {
                        this.quals = res;
                    })
                }
            },
            fetchQPreviousEmployments: function () {

                if (route().current("candidate.auth.details")) {
                    var id = document.getElementById("candidate_id").value;
                    fetch('/candidates/'+id+'/previous_employments')
                        .then(res => res.json())
                        .then(res => {
                            this.employments = res;
                        })
                }else if (!route().current("candidates.create")) {
                    fetch('./previous_employments')
                        .then(res => res.json())
                        .then(res => {
                            this.employments = res;
                        })
                }
            }
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

                $(':input[data-mirror]').each(function () {
                    $(this).mirror($(this).data('mirror'));
                });

                $('.select-multiple').SumoSelect({csvDispCount: 10, up: true});

                window.Parsley.addValidator('requiredIf', {
                    validateString: function (value, requirement) {
                        if (jQuery(requirement).val()) {
                            return !!value;
                        }
                        return true;
                    }, priority: 33
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
            }(jQuery, this);
        },
        created: function () {
            this.fetchQualifications();
            this.fetchQPreviousEmployments();
        }
    });
}
