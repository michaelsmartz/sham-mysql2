window.Vue = require('vue/dist/vue.common.js');
window.Vue = require('vue-tables-2/dist/vue-tables-2.min.js');

import Vue from 'vue'
import Vuex from 'vuex'
import {ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable);
Vue.use(Event);
Vue.use(Vuex);

var table = new Vue({
    el: '#candidates',
    data:  function (){
        return{
            columns: [
                'title',
                'gender',
                'maritalStatus',
                'surname',
                'firstName',
                'dob',
                'personalEmail',
                'homeAddress',
                'phone',
                'idNumber',
                'skills',
                'disabilities',
                'edit',
                'delete',
            ],
            subColumns: [
                'cv',
            ],
            data: getData(),
            options: {
                filter: false,
                filterByColumn: false,
                perPage:2,
                texts: {
                    filter: "Filter:",
                    filterBy: 'Filter by {column}',
                    count:' '
                },
                pagination: { chunk:10 },
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
                sortable: [
                    'title',
                    'gender',
                    'maritalStatus',
                    'surname',
                    'firstName',
                    'dob',
                    'personalEmail',
                    'homeAddress',
                    'phone',
                    'idNumber',
                    'skills',
                    'disabilities',
                ],
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
            subOptions:{
                filter: false,
                filterByColumn: false,
                headings: {
                    cv: "Filename"
                },
                filterable: false
            },
            methods:{
                stages: function(id){
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

function getData() {
    return [{
        id:1,
        title: "Mr",
        gender: "Male",
        maritalStatus: "Single",
        surname: "El",
        firstName: "Nino",
        dob: "23/12/09",
        personalEmail: "elnino@gmail.com",
        homeAddress: "2 wall street, Iraq",
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