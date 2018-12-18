window.Vue = require('vue/dist/vue.common.js');
window.Vue = require('vue-tables-2/dist/vue-tables-2.min.js');

import Vue from 'vue'
import Vuex from 'vuex'
import {ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable);
Vue.use(Event);
Vue.use(Vuex);

var table = new Vue({
    el: '#jobs',
    data:  function (){
        return{
            columns: ['vacancy','jobTitle','hiringManager','location','department','publishedDate','status'],
            subColumns: ['candidate','email','contactNumber','dateApplied','status'],
            data: getData(),
            options: {
                filterByColumn: true,
                perPage:2,
                texts: {
                    filter: "Filter:",
                    filterBy: 'Filter by {column}',
                    count:' '
                },
                pagination: { chunk:10 },
                headings: {
                    vacancy: 'Vacancy',
                    jobTitle: 'Job Title',
                    hiringManager: 'Hiring Manager',
                    location: 'Location',
                    department: 'Department',
                    publishedDate: 'Published Date',
                    status: 'Status',
                },
                sortable: ['vacancy','jobTitle','hiringManager','location','department','publishedDate','status'],
                filterable: ['vacancy','jobTitle','hiringManager','location','department','publishedDate','status']
            },
            subOptions: {
                filterByColumn: false,
                perPage:2,
                texts: {
                    filter: "Filter:",
                    filterBy: 'Filter by {column}',
                    count:' '
                },
                pagination: { chunk:10 },
                headings: {
                    candidate: 'Candidate',
                    email: 'Email',
                    contactNumber: 'Contact Number',
                    dateApplied: 'Date Applied',
                    status: 'Status'
                },
                sortable: ['candidate','email','contactNumber','dateApplied','status'],
                filterable: ['candidate','email','contactNumber','dateApplied','status']
            }
        }

    }
});

function getData() {
    return [{
        jobTitle: "Accountant",
        vacancy: "Accounts Clerk",
        hiringManager: "Tom John",
        location: "Zimbabwe",
        department: "Finance",
        status: "Published",
        publishedDate: "2015-04-24T01:46:50.459583",
        created_at: "2015-04-24T01:46:50.459583",
        updated_at: "2015-04-24T01:46:50.459593",
        applicants: [{
            candidate:"Iron man",
            email:"ironman@gmail.com",
            contactNumber: "+23052222222",
            dateApplied: "2018-10-17",
            status: "Application received"
        },{
            candidate:"Wolverine",
            email:"wolverine@gmail.com",
            contactNumber: "+23054444444",
            dateApplied: "2018-11-17",
            status: "Shortlisted"
        }],
        id: 245
    }, {
        jobTitle: "Assistant Architect",
        vacancy: "Software Development Manager",
        hiringManager: "Alan Parrish",
        location: "Zambia",
        department: "IT",
        status: "Published",
        publishedDate: "2015-04-24T01:46:50.457459",
        created_at: "2015-04-24T01:46:50.457459",
        updated_at: "2015-04-24T01:46:50.457468",
        applicants: [{
            candidate:"Maxim Bady",
            email:"maxim@gmail.com",
            contactNumber: "+23057777777",
            dateApplied: "2018-10-18",
            status: "Application received"
        }],
        id: 244
    }, {
        jobTitle: "Front End Developer",
        vacancy: "Front End Developer",
        hiringManager: "TheGeek",
        location: "Yemen",
        department: "IT",
        status: "Published",
        publishedDate: "2015-04-24T01:46:50.454731",
        created_at: "2015-04-24T01:46:50.454731",
        updated_at: "2015-04-24T01:46:50.454741",
        applicants: [],
        id: 243
    }];
}