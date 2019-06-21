window.Vue = require('vue/dist/vue.common.js');
window.Vue = require('vue-tables-2/dist/vue-tables-2.min.js');

require('sumoselect');
require('parsleyjs');

import Vue from 'vue'
import Vuex from 'vuex'
import {ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable);
Vue.use(Event);
Vue.use(Vuex);

if(document.getElementById("recruitment-requests")) {
    const rr = new Vue({
        el: '#recruitment-requests',
        data: {
            interview: {
                interview_types: ['Phone', 'Skype', 'Panel', 'Assessment'],
                interviewers: '',
                location: '',
                schedule_date: '',
                schedule_comment: '',
            },
            interviews: [],
            errors: [],
            jobTitle: null,
            description: null,
            shortDescription: null,
            yearExperience: null,
            minSalary: null,
            maxSalary: null,
            showSalary: false,
            showEndDate: false,
            internalRecruitment: false,
            externalRecruitment: false,
            departments: [
                "Finance",
                "Development",
                "Testing"
            ],
            employmentTypes: [
                "Full-time",
                "Part-time",
                "Contract",
                "Temporary",
                "Other",
            ],
            qualifications: [
                "Higher School Certificate",
                "Certificate",
                "Diploma",
                "Degree",
                "Masters",
                "PhD",
            ],
            skills: [
                "skill1",
                "skill2",
                "skill3",
            ],
            selectedDepartment: null,
            selectedEmploymentType: null,
            selectedInterviewType: null,
            selectedQualification: null,
            selectedSkill: null,
        },
        methods: {
            checkForm: function (e) {
                if (this.jobTitle && this.description && this.shortDescription) {
                    return true;
                }

                this.errors = [];

                if (!this.jobTitle) {
                    this.errors.push('Job title is required.');
                }
                if (!this.shortDescription) {
                    this.errors.push('Short description is required.');
                }
                if (!this.description) {
                    this.errors.push('Full job description is required.');
                }

                if (this.showSalary && !this.minSalary) {
                    this.errors.push('Minimum salary is required.');
                }

                if (this.showSalary && !this.maxSalary) {
                    this.errors.push('Maximum salary is required.');
                }

                if (!this.selectedDepartment) {
                    this.errors.push('Department is required.');
                }

                if (!this.selectedEmploymentType) {
                    this.errors.push('Employment Type is required.');
                }

                if (!this.selectedQualification) {
                    this.errors.push('Qualification is required.');
                }

                if (!this.yearExperience) {
                    this.errors.push('Years of experience is required.');
                }

                if (!this.skills) {
                    this.errors.push('Skill is required.');
                }

                e.preventDefault();
            },
            selectedDepartmentFunc: function () {
                //console.log(this.selectedDepartment)
            },
            selectedEmploymentTypeFunc: function () {
                //console.log(this.selectedEmploymentType);
                if (this.selectedEmploymentType === "Temporary") {
                    this.showEndDate = true;
                } else {
                    this.showEndDate = false;
                }
            },
            submitForm: function (event) {
                event.preventDefault();
            }
        },
        mounted: function () {
            +function ($, el) {
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
            }(jQuery, this);
        }
    });
}