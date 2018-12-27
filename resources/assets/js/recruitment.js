window.Vue = require('vue/dist/vue.common.js');

var vm = new Vue({
	el:  "#recruitment",
	data: {
        people: [
			{ 
				name: "Bill Gates", status: "applied", picture:"", jobTitle:"Astronaut",
				documents: [
					{name:"Curriculum Vitae.docx"},
					{name:"Application Letter.docx"}
				]

			},
			{ 
				name: "Steve Jobs", status: "applied", picture:"", jobTitle:"Chief Marketing Officer",
				documents: []
			},
			{
				name: "George Clooney", status: "review", picture:"", jobTitle:"Web Developer",
				documents: []
			},
            {
				name: "Meryl Streep", status: "interviewing", picture:"", jobTitle:"Web Developer",
				documents: [],
                interviewTypes:[
                    "Phone Interview",
                    "Structured Interview",
                    "Problem Solving Interview",
                    "Skype Interview",
                    "Case Interview",
				],
                interviewers:[
                	"John w henry",
					"Mike chung"
				],
				location: "Port Louis, Mauritius",
				from: "",
				to: ""
			},
			{ 
				name: "Amy Poehler", status: "interviewing", picture:"", jobTitle:"Chief Marketing Officer",
				documents: [],
                interviewTypes: [
                    "Phone Interview",
                    "Structured Interview"
                ],
                interviewers:[],
                location: "Grand Bay, Mauritius",
                from: "",
                to: ""
			},
			{ 
				name: "Lady of Lórien", status: "interviewing", picture:"", jobTitle:"Astronaut",
				documents: [],
                interviewTypes: [
                    "Phone Interview",
                    "Structured Interview",
                    "Problem Solving Interview",
                    "Skype Interview",
                    "Case Interview",
                ],
                interviewers:[],
                location: "",
                from: "",
                to: ""
			},
			{ 
				name: "BB8", status: "offer", picture:"", jobTitle:"",
				documents: []
			},
			{ 
				name: "Michael Scott", status: "contract", picture:"", jobTitle:"",
				documents: []
			}
		],
        selectedCategory: "applied",
        current: {},
        counter: 0,
        lastInterview: true,
        submitInterview: false,
	},
	computed: {
		filteredPeople: function() {
			var vm = this;
			var category = vm.selectedCategory;
			
			if(category === "All") {
				return vm.people;
			} else {
				return vm.people.filter(function(person) {
					return person.status === category;
				});
			}
		}
	},
	methods:{
		setCurrent: function(item) {
			this.current = item;
            this.counter = 0;
            this.lastInterview = false;
		},
        increment() {
            this.counter++;
        }
	}
});
