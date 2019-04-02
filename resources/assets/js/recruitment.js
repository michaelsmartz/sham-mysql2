import {on} from 'delegated-events';
import Modal from './components/Modal.vue';
window.Vue = require('vue/dist/vue.common.js');

let download = require("downloadjs");
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
		interviews: [],
		offerLetters: [],
		currentOffer: 0
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
			// handle empty offer letters error
			if(item.offers.length == 0) {
				item.offers.push({offer_id: 0});
			} else {
				this.currentOffer = item.offers[0].offer_id;
			}
			this.current = item;
			this.counter = 0;
			this.lastInterview = false;
		},
		increment() {
			this.counter++;
		},
		route: function(){
			return window.route();
		},
		pipelineSwitchState: function (id, title, current, candidate, newState) {
			var vm = this;
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
							if (res.ok == true) {
								alerty.toasts('Operation successful',{'place':'top','time':3500},function(){vm.fetchCandidates();});
							}

						});
				}
			);
			//return window.pipelineSwitchState(id, $event, candidate, newState);
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
		fetchCandidates: function() {
			if (!route().current("candidates.create")) {
				fetch('./candidates', {
					credentials: "same-origin",
					headers: {
						"Content-Type": "application/json",
						"Accept": "application/json, */*",
						"X-Requested-With": "XMLHttpRequest",
						"X-CSRF-TOKEN": token
					}
				  })
					.then(res => res.json())
					.then(res => {
						this.people = res;
					}).catch(err => {
						// Do something for an error here
						console.log("Error Reading data " + err);
					});
			}
		},
		fetchOfferLetters: function() {
			fetch('./offer-letters', {
				credentials: "same-origin",
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": token
				}
			  })
			.then(res => res.json())
			.then(res => {
				this.offerLetters = res;
			}).catch(err => {
				// Do something for an error here
				console.log("Error Reading data " + err);
			  });
		},
		getBackground: function(src){
			if (src !== null) {
				return 'background-image: ' + 'url(' + src + ')';
			} else {
				return "background-image: " + "url('/img/avatar.png')";
			}
			
		},
		downloadOffer: function(){
			var startingOn = $('#starting_on').val(),
				contractId = $('#contract_id').val(),
				offerId = $('#offer_id option:selected').val();
				console.log(offerId);

			fetch('./candidate/' + this.current.id + '/download-offer', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": token
				},
				method: 'post',
				body: JSON.stringify({ starting_on: startingOn, contract_id: contractId, offer_id: offerId}),
				credentials: "same-origin"
			}).then(function(resp) {
				return resp.blob();
			}).then(function(blob) {
				download(blob, 'offer letter.pdf');
			});
		},
        importHired: function(){
            var vm = this;
            var comments = $('#hired_comments').val(),
                employee_no = $('#employee_no').val();

            alerty.confirm(
                "Are you sure to <strong class='text-danger'> import </strong> candidate " + vm.current.name + "'s data <strong class='text-danger'></strong>?<br>", {
                    okLabel: '<span class="text-danger">Yes</span>',
                    cancelLabel: 'No'
                },
                function () {
                    fetch('./candidate/' + vm.current.id + '/hired', {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'post',
                        body: JSON.stringify({ comments: comments, employee_no: employee_no}),
                        credentials: "same-origin"
                    })
					.then(function (res) {
						if (res.ok == true) {
							alerty.toasts('Operation successful',{'place':'top','time':3500},function(){
                                $('.hired').attr('disabled','disabled');
                                $('#hired_comments').attr('disabled','disabled');
                                $('#employee_no').attr('disabled','disabled');
							});
						}

					});
                }
            );
        }
	},
	created: function () {
		this.fetchCandidates();
	},
	mounted: function() {
		on('focusin', 'input.datepicker', function(event) {

			// Use the picker object directly.
			//var picker = $(this).pickadate('picker');
			
			//if(picker === undefined) {
			//	picker = $(this).pickadate().pickadate('picker');
			//}
		});
		this.fetchOfferLetters();
	},
	components: {
		'modal': Modal
	},
	filters: {
		stageCount:function(people, status){
			if (status == 0 || status === void 0) {
				return people.length;
			} else {
				return people.filter(function(person) {
					return person.status[0].status == status
				}).length;
			}
		}
	}
});