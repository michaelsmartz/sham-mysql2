window.Vue = require('vue/dist/vue.common.js');
window.Vue = require('vue-tables-2/dist/vue-tables-2.min.js');

import vue, {ClientTable} from 'vue-tables-2';
vue.use(ClientTable);

new Vue({
    el: '#candidates',
    data: getData(),
    options: {
        headings: {
            vacancy: 'Vacancy',
            jobTitle: 'Job Title',
            hiringManager: 'Hiring Manager',
            location: 'Location',
            department: 'Department',
            publishedDate: 'Published Date',
            status: 'Status',
        },
        sortable: ['name', 'code'],
        filterable: ['name', 'code']
    },
    methods:{

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
        uri: "http://google.com",
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
        uri: "http://google.com",
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
        uri: "http://google.com",
        id: 243
    }];
}