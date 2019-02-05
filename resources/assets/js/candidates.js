window.Vue = require('vue/dist/vue.common.js');
window.Vue = require('vue-tables-2/dist/vue-tables-2.min.js');

require('sumoselect');

import Vue from 'vue'
import Vuex from 'vuex'
import {ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable);
Vue.use(Event);
Vue.use(Vuex);

if(document.getElementById("candidates-table")) {
    var table = new Vue({
        el: '#candidates-table',
        data: function () {
            return {
                columns: [
                    'title',
                    'gender',
                    'surname',
                    'firstName',
                    'personalEmail',
                    'phone',
                    'actions'
                ],
                subColumns: [
                    'cv',
                ],
                data: getData(),
                options: {
                    filter: false,
                    filterByColumn: false,
                    perPage: 2,
                    texts: {
                        filter: "Filter:",
                        filterBy: 'Filter by {column}',
                        count: ' '
                    },
                    pagination: {chunk: 10},
                    headings: {
                        title: "Title",
                        gender: "Gender",
                        maritalStatus: "Marital Status",
                        surname: "Surname",
                        firstName: "FirstName",
                        dob: "Date of Birth",
                        personalEmail: "Personal Email",
                        homeAddress: "Home Address",
                        phone: "Phone",
                        idNumber: "ID number",
                        skills: "Skills",
                        qualifications: "Qualifications",
                        disabilities: "Disabilities",
                    },
                    // sortable: [
                    //     'title',
                    //     'gender',
                    //     'maritalStatus',
                    //     'surname',
                    //     'firstName',
                    //     'dob',
                    //     'personalEmail',
                    //     'homeAddress',
                    //     'phone',
                    //     'idNumber',
                    //     'skills',
                    //     'disabilities',
                    // ],
                    sortable: [],
                    filterable: false
                    // filterable: [
                    // 'title',
                    // 'gender',
                    // 'maritalStatus',
                    // 'surname',
                    // 'firstName',
                    // 'dob',
                    // 'personalEmail',
                    // 'homeAddress',
                    // 'phone',
                    // 'idNumber',
                    // 'skills',
                    // 'disabilities'
                    // ]
                },
                subOptions: {
                    filter: false,
                    filterByColumn: false,
                    headings: {
                        cv: "Filename"
                    },
                    filterable: false
                },
                methods: {
                    stages: function (id) {
                        window.location.href = '/recruitment';
                    },
                    erase: function (id) {
                        alert(id);
                    },
                    edit: function (id) {
                        window.location.href = '/recruitment';
                    },
                    download: function (id) {
                        alert(id);
                    }
                }
            }
        }
    });
}

function getData() {
    return [{
        id:1,
        title: "Mr",
        gender: "Male",
        surname: "El",
        firstName: "Nino",
        personalEmail: "elnino@gmail.com",
        phone: "+3322323333",
        idNumber: "p1212362112436w",
        skills: "php",
        qualifications: "Masters",
        disabilities: "Tinnitus, Mobility of limbs",
        attachments: [{
            cv:"cv.pdf"
        },{
            cv:"cv2.pdf"
        },
        {
            cv:"cv3.pdf"
        }],
        photo: "photo.jpg"
    },{
        id:2,
        title: "Miss",
        gender: "Female",
        maritalStatus: "Single",
        surname: "Nina",
        firstName: "Williams",
        dob: "23/12/89",
        personalEmail: "NinaWilliams@gmail.com",
        homeAddress: "43 river land, Long Mountain",
        phone: "+33444444444",
        idNumber: "p527993424234o",
        skills: "Mysql",
        qualifications: "phD",
        disabilities: "Optic Atropy",
        attachments: [{
            cv:"cv.pdf"
        },{
            cv:"cv2.pdf"
        }],
        photo: "photo.jpg"
    },
    ];
}

if(document.getElementById("candidates")) {
    const rr = new Vue({
        el: '#candidates',
        data: {
            qual: {
                reference: '', description: '', institution: '', obtained_on: '',
                student_no: ''
            },
            quals: [],
            employment: {
                previous_employer: '', position: '', salary: '', reason_leaving: ''
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
                fetch('./qualifications')
                    .then(res => res.json())
                    .then(res => {
                        this.quals = res;
                    })
            },
            fetchQPreviousEmployments: function () {
                fetch('./previous_employments')
                    .then(res => res.json())
                    .then(res => {
                        this.employments = res;
                    })
            }
        },
        mounted: function () {
            +function ($, el) {
                $('.select-multiple').SumoSelect({csvDispCount: 10, up: true});
            }(jQuery, this);
        },
        created: function () {
            this.fetchQualifications();
        }
    });
}