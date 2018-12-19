window.Vue = require('vue/dist/vue.common.js');

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
