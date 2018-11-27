window.Vue = require('vue/dist/vue.common.js');

var vm = new Vue({
	el:  "#recruitment",
	data: {
		people: [
			{ name: "Bill Gates", status: "applied", picture:"", jobTitle:"Astronaut" },
			{ name: "Steve Jobs", status: "applied", picture:"", jobTitle:"Chief Marketing Officer" },
			{ name: "Jeff Bezos", status: "applied", picture:"", jobTitle:"Operator" },
			{ name: "George Clooney", status: "review", picture:"", jobTitle:"Web Developer" },
			{ name: "Meryl Streep", status: "review", picture:"", jobTitle:"" },
			{ name: "Amy Poehler", status: "interviewing", picture:"", jobTitle:"" },
			{ name: "Lady of Lórien", status: "interviewing", picture:"", jobTitle:"" },
			{ name: "BB8", status: "offer", picture:"", jobTitle:"" },
			{ name: "Michael Scott", status: "contract", picture:"", jobTitle:"" }
		],
		selectedCategory: "All",
		current: {}
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
		}
	}
});
