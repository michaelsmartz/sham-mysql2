import Modal from './components/Modal.vue';
window.Vue = require('vue/dist/vue.common.js');

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

var vm = new Vue({
	el:  "#recruitment",
	data: {
		showModal: false,
		candidates : [],
        people: [
			{ 
				name: "Bill Gates", status: "applied", picture:"", jobTitle:"Astronaut",
				email: "b@g.com", phone: "12345", birth_date:"1990-01-02",
				id:1,
				qualifications:[
					{description:"XXX", institution:"Abc", obtained_on:"2005"},
					{description:"Zzz", institution:"Dbc", obtained_on:"2006"}
				],
				documents: [
					{name:"Curriculum Vitae.docx"},
					{name:"Application Letter.docx"},
					{name:"Anything Else.pdf"}
				]

			},
			{ 
				name: "Steve Jobs", status: "applied", picture:"", jobTitle:"Chief Marketing Officer",
				email: "s@j.com", phone: "12345", birth_date:"1990-01-02",
				id:2,
				qualifications:[
					{description:"Curriculum Vitae.docx", institution:"abc", obtained_on:"2005"},
					{description:"Curriculum Vitae.docx", institution:"abc", obtained_on:"2005"}
				],
				documents: []
			},
			{
				name: "George Clooney", status: "review", picture:"", jobTitle:"Web Developer",
				email: "g@c.com", phone: "12345", birth_date:"1990-01-02",
				id:3,
				qualifications:[
					{description:"Curriculum Vitae.docx", institution:"abc", obtained_on:"2005"},
					{description:"Curriculum Vitae.docx", institution:"abc", obtained_on:"2005"}
				],
				documents: []
			},
            {
				name: "Meryl Streep", status: "interviewing", picture:"", jobTitle:"Web Developer",
				email: "m@s.com", phone: "12345", birth_date:"1990-01-02",
				id:4,
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
				email: "b@g.com", phone: "12345", birth_date:"1990-01-02",
				id:5,
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
				email: "b@g.com", phone: "12345", birth_date:"1990-01-02",
				id:6,
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
				name: "BB8", status: "offer", picture:"", jobTitle:"",id:7,
				email: "b@g.com", phone: "12345", birth_date:"1990-01-02",
				documents: []
			},
			{ 
				name: "Michael Scott", status: "contract", picture:"", jobTitle:"",id:8,
				email: "b@g.com", phone: "12345", birth_date:"1990-01-02",
				documents: []
			}
		],
        selectedCategory: "All",
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
		},

	},
	methods:{
		setCurrent: function(item) {
			this.current = item;
            this.counter = 0;
            this.lastInterview = false;
		},
        increment() {
            this.counter++;
		},
		pipelineSwitchState: function(id, title, current, candidate, newState){
			alerty.confirm(
				"Are you sure to <strong class='text-danger'>" + title + "</strong> for the candidate <strong class='text-danger'>" + current.name + "</strong>?<br>",
				{
					okLabel: '<span class="text-danger">Yes</span>',
					cancelLabel: 'No'
				},
				function() {
					fetch('.1/switch/' + current.id + '/' + newState,
					{
						headers: {
						  "Content-Type": "application/json",
						  "Accept": "application/json, text-plain, */*",
						  "X-Requested-With": "XMLHttpRequest",
						  "X-CSRF-TOKEN": token
						 },
						method: 'post',
						credentials: "same-origin"
					})
					.then(res = res.json());
				}
			);
			//return window.pipelineSwitchState(id, $event, candidate, newState);
		},
		setVal(item,h,b,f) {
			this.current = item;
			console.log(this.current);
		},
        fetchCandidates: function()
        {
            fetch('./candidates')
            .then(res = res.json())
            .then(res => {
                this.candidates = res;
            })
        }
	},
    created: function()
    {
        this.fetchCandidates();
    },
    components: {
        'modal': Modal
    }
});
