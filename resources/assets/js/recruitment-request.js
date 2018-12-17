window.Vue = require('vue/dist/vue.common.js');

const rr = new Vue({
    el: '#recruitment-request',
    data: {
        errors: [],
        jobTitle: null,
        description: null,
        shortDescription: null,
        salary: null,
        showSalary: false,
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
        selectedDepartment: null,
        selectedEmploymentType: null,
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

            if(this.showSalary && !this.salary){
                this.errors.push('Salary is required.');
            }

            if(!this.selectedDepartment){
                this.errors.push('Department is required.');
            }

            if(!this.selectedEmploymentType){
                this.errors.push('Employment Type is required.');
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
