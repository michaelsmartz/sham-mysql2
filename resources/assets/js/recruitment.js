window.Vue = require('vue/dist/vue.common.js');

var vm = new Vue({
	el:  "#recruitment",
	data: {
        interviewType : null,
        interviewTypes: [
            "Internal",
            "External"
        ],
        people: [
			{ 
				name: "Bill Gates", status: "applied", picture:"", jobTitle:"Astronaut",
				documents: [
					{name:"Curriculum Vitae.docx"},
					{name:"Application Letter.docx"}
				],
			},
			{ 
				name: "Steve Jobs", status: "applied", picture:"", jobTitle:"Chief Marketing Officer",
				documents: [] 
			},
			{ 
				name: "Jeff Bezos", status: "applied", picture:"", jobTitle:"Operator",
				documents: [] 
			},
			{ 	
				name: "George Clooney", status: "review", picture:"", jobTitle:"Web Developer",
				documents: [] 
			},
			{ 
				name: "Meryl Streep", status: "review", picture:"", jobTitle:"",
				documents: [] 
			},
			{ 
				name: "Amy Poehler", status: "interviewing", picture:"", jobTitle:"",
				documents: []
			},
			{ 
				name: "Lady of Lórien", status: "interviewing", picture:"", jobTitle:"",
				documents: []
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
        counter: 0
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
		},
        increment() {
            this.counter++;
        }
	}
});
