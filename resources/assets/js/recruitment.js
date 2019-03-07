import Modal from './components/Modal.vue';
window.Vue = require('vue/dist/vue.common.js');

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// usage: {{ file.size | prettyBytes }}
Vue.filter('prettyBytes', function (num) {
	// jacked from: https://github.com/sindresorhus/pretty-bytes
	if (typeof num !== 'number' || isNaN(num)) {
		throw new TypeError('Expected a number');
	}

	var exponent;
	var unit;
	var neg = num < 0;
	var units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

	if (neg) {
		num = -num;
	}

	if (num < 1) {
		return (neg ? '-' : '') + num + ' B';
	}

	exponent = Math.min(Math.floor(Math.log(num) / Math.log(1000)), units.length - 1);
	num = (num / Math.pow(1000, exponent)).toFixed(2) * 1;
	unit = units[exponent];

	return (neg ? '-' : '') + num + ' ' + unit;
});


var vm = new Vue({
	el: "#recruitment",
	data: {
		showModal: false,
		candidates: [],
		people: [],
		selectedCategory: 0,
		current: false,
		counter: 0,
		lastInterview: true,
		submitInterview: false,
		interviews: []
	},
	computed: {
		filteredPeople: function () {
			var vm = this;
			var category = vm.selectedCategory;

			if (category === 0) {
				return vm.people;
			} else {
				return vm.people.filter(function (person) {
					return person.status[0].status === category;
				});
			}
		},
	},
	methods: {
		setCurrent: function (item) {
			this.current = item;
			this.counter = 0;
			this.lastInterview = false;
		},
		increment() {
			this.counter++;
		},
		pipelineSwitchState: function (id, title, current, candidate, newState) {
			alerty.confirm(
				"Are you sure to <strong class='text-danger'>" + title + "</strong> for the candidate <strong class='text-danger'>" + current.name + "</strong>?<br>", {
					okLabel: '<span class="text-danger">Yes</span>',
					cancelLabel: 'No'
				},
				function () {
					fetch('./switch/' + current.id + '/' + newState, {
							headers: {
								"Content-Type": "application/json",
								"Accept": "application/json, text-plain, */*",
								"X-Requested-With": "XMLHttpRequest",
								"X-CSRF-TOKEN": token
							},
							method: 'post',
							credentials: "same-origin"
						})
						.then(function (res) {
							if (res == true) {
								alerty.toasts('Operation successful');
							}

						});
				}
			);
			//return window.pipelineSwitchState(id, $event, candidate, newState);
		},
        loadInterviewTypes: function (current) {
            if (current.id) {
                fetch('./interviewing/' + current.id, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: 'post',
                    credentials: "same-origin"
                })
				.then(res => res.json())
				.then(res => {
                    let _this = this;
					console.log(res);
                    _this.interviews = res;
				});
            }
        },
        editInterviewForm: function(interview_id, candidate_id){
            this.loadUrl('stages/' + interview_id + '/candidate/'+ candidate_id + '/edit-interview');
		},
        loadUrl: function(url) {
            $(".light-modal-body").empty().html('Loading...please wait...');
            $.get(url).done(function(data) {
                $(".light-modal-heading").empty().html(data.title);
                $(".light-modal-body").empty().html(data.content);
                $(".light-modal-footer .buttons").empty().html(data.footer);
                $("#modalForm").attr('action',data.url);

                cleanUrlHash();

                $('.multipleSelect').each(function(){
                    $(this).multiselect({
                        submitAllLeft:false,
                        sort: false,
                        keepRenderingSort: false,
                        search: {
                            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                        },
                        fireSearch: function(value) {
                            return value.length > 3;
                        }
                    });
                });
            }).fail(function() {
                alerty.alert("An error has occurred. Please try again!",{okLabel:'Ok'});
            });
        },
		setVal(item, h, b, f) {
			this.current = item;
		},
		fetchCandidates: function () {
			if (!route().current("candidates.create")) {
				fetch('./candidates')
					.then(res => res.json())
					.then(res => {
						this.people = res;
					})
			}
		},
		getBackground: function(src){
			if (src !== null) {
				return 'background-image: ' + 'url(' + src + ')';
			} else {
				return "background-image: " + "url('/img/avatar.png')";
			}
			
		}
	},
	created: function () {
		this.fetchCandidates();
	},
	components: {
		'modal': Modal
	},
	filters: {
		applied:function(people) {
			return people.length;
		},
		interviewing:function(people) {
			return people.filter(function(person) {
				return person.status[0].status == 1
		  }).length;
		},
		offer:function(people) {
			return people.filter(function(person) {
				return person.status[0].status == 2
		  }).length;
		},
		contract:function(people) {
			return people.filter(function(person) {
				return person.status[0].status == 3
		  }).length;
		},
		hired:function(people) {
			return people.filter(function(person) {
				return person.status[0].status == 4
		  }).length;
		},
	}
});