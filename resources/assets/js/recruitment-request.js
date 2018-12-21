window.Vue = require('vue/dist/vue.common.js');
window.Vue = require('vue-tables-2/dist/vue-tables-2.min.js');

import Vue from 'vue'
import Vuex from 'vuex'
import {ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable);
Vue.use(Event);
Vue.use(Vuex);

const table = new Vue({
    el: '#recruitment-requests-table',
    data:{
        columns: [
            'jobTitle',
            'shortDescription',
            'description',
            'department',
            'employmentType',
            'qualification',
            'experience',
            'recruitment',
            'edit',
            'pipelines',
            'delete',
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
                jobTitle: 'Job Title',
                shortDescription: 'Short Description',
                description: 'Description',
                department: 'Department',
                employmentType: 'Employment Type',
                qualification: 'Qualification',
                experience: 'Experience',
                recruitment: 'Recruitment',
            },
            // sortable: [
            //     'jobTitle',
            //     'shortDescription',
            //     'description',
            //     'department',
            //     'employmentType',
            //     'qualification',
            //     'experience',
            //     'recruitment',
            // ],
            // filterable: [
            //     'jobTitle',
            //     'shortDescription',
            //     'description',
            //     'department',
            //     'employmentType',
            //     'qualification',
            //     'experience',
            //     'recruitment'
            // ],

            sortable: [],
            filterable: false,
        },
    },
    methods:{
        pipelines: function(id){
            window.location.href = '/recruitment';
        },
        delete: function (id) {
            alert(id);
        },
        edit: function (id) {
            window.location.href = '/recruitment';
        }
    }
});

const rr = new Vue({
    el: '#recruitment-requests',
    data: {
        errors: [],
        jobTitle: null,
        description: null,
        shortDescription: null,
        yearExperience: null,
        minSalary: null,
        maxSalary: null,
        showSalary: false,
        internalRecruitment: false,
        externalRecruitment: false,
        departments: [
             "Finance",
             "Development",
             "Testing"
        ],
        employmentTypes:[
             "Full-time",
             "Part-time",
             "Contract",
             "Temporary",
             "Other",
        ],
        qualifications:[
            "Higher School Certificate",
            "Certificate",
            "Diploma",
            "Degree",
            "Masters",
            "PhD",
        ],
        selectedDepartment: null,
        selectedEmploymentType: null,
        selectedQualification: null,
    },
    methods:{
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

            if(this.showSalary && !this.minSalary){
                this.errors.push('Minimum salary is required.');
            }

            if(this.showSalary && !this.maxSalary){
                this.errors.push('Maximum salary is required.');
            }

            if(!this.selectedDepartment){
                this.errors.push('Department is required.');
            }

            if(!this.selectedEmploymentType){
                this.errors.push('Employment Type is required.');
            }

            if(!this.selectedQualification){
                this.errors.push('Qualification is required.');
            }

            if(!this.yearExperience){
                this.errors.push('Years of experience is required.');
            }

            e.preventDefault();
        },
        selectedDepartmentFunc: function() {
            console.log(this.selectedDepartment)
        },
        selectedEmploymentTypeFunc: function() {
            console.log(this.selectedEmploymentType)
        },
    }
});

function getData() {
    return [{
        jobTitle: "Finance Manager",
        shortDescription: 'Monitor the day-to-day financial operations within the company, ' +
            'such as payroll, invoicing, and other transactions. Oversee financial department employees, ' +
            'including financial assistants and accountants',
        description : 'Responsibilities of the job include:\n' +
            'collating, preparing and interpreting reports, budgets, accounts, commentaries and financial statements\n' +
            'undertaking strategic analysis and assisting with strategic planning\n' +
            'producing long-term business plans\n' +
            'undertaking research into pricing, competitors and factors affecting performance\n' +
            'controlling income, cash flow and expenditure',
        department: 'Finance',
        employmentType: 'Full-time',
        qualification: 'PhD',
        experience: 10,
        recruitment: 'Internal',
        created_at: "2015-04-24T01:46:50.459583",
        updated_at: "2015-04-24T01:46:50.459593",
        id: 245
    }, {
        jobTitle: "Assistant Architect",
        shortDescription: 'A valid New York State Registration as an Architect. Under supervision of the Director, the candidate will serve as an Assistant Architect in the Land Use...',
        description : 'Under supervision of the Director, the candidate will serve as an Assistant Architect ' +
            'in the Land Use Review unit within the Division of Legal Affairs. S/he will review ' +
            'various types of applications such as ULURP, license agreements and waivers; conduct ' +
            'topographical research and gather information from various agencies; consult with other ' +
            'DOT divisions for their opinion, conduct field surveys, investigations; participate in meetings; ' +
            'prepare maps using ArcGIS; review design plans, sketches, maps, and other technical drawings ' +
            'and make recommendations; prepare correspondence for supervisor’s review; respond to inquiries ' +
            'from communities, elected officials and their constituencies related to street system; provide ' +
            'assistance to and coordinate work with other Divisions of DOT; engage in investigations and studies ' +
            'pertaining to land use and transportation, provide authoritative interpretations of New York City ' +
            'tax maps, sanborn maps and City Maps. S/he will maintain real estate portfolio of DOT, review and ' +
            'interpret deeds, real estate agreements, metes and bounds descriptions and title search documents; ' +
            'conduct title search as necessary. Perform other related duties as assigned by the supervisor.',
        department: 'Construction',
        employmentType: 'Full-time',
        qualification: 'Degree',
        experience: 5,
        recruitment: 'External',
        created_at: "2015-04-24T01:46:50.457459",
        updated_at: "2015-04-24T01:46:50.457468",
        id: 244
    }, {
        jobTitle: "Front End Developer",
        shortDescription: 'Angular 7 developer needed',
        description : 'We are looking for a Front-End Web Developer who is motivated to combine ' +
            'the art of design with the art of programming. Responsibilities will include translation ' +
            'of the UI/UX design wireframes to actual code that will produce visual elements of the application. ' +
            'You will work with the UI/UX designer and bridge the gap between graphical design and technical ' +
            'implementation, taking an active role on both sides and defining how the application looks ' +
            'as well as how it works.',
        department: 'IT',
        employmentType: 'Full-time',
        qualification: 'degree',
        experience: 7,
        recruitment: 'Both',
        created_at: "2015-04-24T01:46:50.454731",
        updated_at: "2015-04-24T01:46:50.454741",
        id: 243
    }];
}