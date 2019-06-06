import {on} from 'delegated-events';
import moment from 'moment';

window.Vue = require('vue/dist/vue.common.js');
Vue.config.productionTip = false;

let download = require("downloadjs");
let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY')
  }
});

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

Vue.prototype.window = window;

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
		contracts: [],
		currentOffer: 0,
		currentOfferStartsOn: '',
		currentContract: 0,
        currentComment: '',
		interviewMedias: [],
		interviewOverallComment: ""
	},
	computed: {
		filteredPeople: function () {
			var vm = this;
			var category = vm.selectedCategory;

			if (category === 0) {
				return vm.people;
			}
			else if (category === 1){
				return vm.people.filter(function (person) {
					return (person.status[0].status >= 1 || person.status[0].status === 2 || person.status[0].status === -2);
				});
			}
			else {
				return vm.people.filter(function (person) {
					return (person.status[0].status >= 0 && person.status[0].status === category);
				});
			}
		}
	},
	methods: {
		setCurrent: function (item) {
			let scope = this;
			// handle empty offer letters error
			if(item.offers.length == 0) {
				item.offers.push({offer_id: 0,starting_on:""});
				this.currentOffer = 0;
			} else {
				this.currentOffer = item.offers[0].offer_id;
				this.currentOfferStartsOn = item.offers[0].starting_on;
			}
			if(item.contracts.length == 0) {
				item.contracts.push({contract_id: 0});
				this.currentContract =0;
			} else {
				this.currentContract = item.contracts[0].contract_id;
			}

            if(item.recruitment_status.length == 0) {
                this.currentComment = "";
            } else {
                this.currentComment = item.recruitment_status[0].comment;
            }
			if(item.interviews.length == 0) {
				scope.interviewMedias = [];
			}else{
				$.each(item.interviews, function (index, obj ) {
					scope.interviewMedias[index] = [];
					$.each(obj.interviewMedias, function (key, value){
						let medias = [];

						if (value.hasOwnProperty('id')) {
							medias['id'] = value.id;
						}
						if (value.hasOwnProperty('filename')) {
							medias['filename'] = value.filename;
						}
						if (value.hasOwnProperty('extension')) {
							medias['extension'] = value.extension;
						}

						if (value.hasOwnProperty('mediable_id')) {
							medias['mediable_id'] = value.mediable_id;
						}

						scope.interviewMedias[index][key] = medias;
					});
				});
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
		uploader: function(){
			return true;
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
        editInterviewForm: function(interview_id, candidate_id, e){
			e.stopPropagation();
            this.loadUrl('stages/' + interview_id + '/candidate/'+ candidate_id + '/edit-interview');
		},
        uploadSignedOffer: function(candidateId){
			var offerId = $('#offer_id option:selected').val();
            this.loadUrl('./candidate/'+ candidateId + '/offer/' + offerId + '/upload-offer-form');
		},
        uploadSignedContract: function(candidateId){
			var contractId = $('#contract_id option:selected').val();
            this.loadUrl('./candidate/'+ candidateId + '/contract/' + contractId + '/upload-contract-form');
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
		deleteInterviewMedia: function(current, interview_id, media, e){
			let vm = this;
			e.stopPropagation();

			alerty.confirm(
				"Are you sure to delete interview media <strong class='text-danger'>"+ media.filename + "." + media.extension+"</strong> for the candidate <strong class='text-danger'>" + current.name + "</strong>?<br>", {
					okLabel: '<span class="text-danger">Yes</span>',
					cancelLabel: 'No'
				},
				function () {
					fetch('./candidate/' + current.id + '/interview/' + interview_id + '/delete-media', {
						headers: {
							"Content-Type": "application/json",
							"Accept": "application/json, */*",
							"X-Requested-With": "XMLHttpRequest",
							"X-CSRF-TOKEN": token
						},
						method: 'post',
						body: JSON.stringify({ media_id: media.id, mediable_id: media.mediable_id}),
						credentials: "same-origin"
					}).then(function(resp) {
						if (resp.ok == true) {
							alerty.toasts('Operation successful',{'place':'top','time':3500},function(){
								vm.interviewMedias = vm.removeIndexMultiDimensionalArr(vm.interviewMedias, media.id);
							});
						}
					});
				}
			);
		},

		/**
		 * Remove Index of Multidimensional Array
		 * @param arr {!Array} - the input array
		 * @param media_id {object} - the value to search
		 * @return {Array}
		 */
		removeIndexMultiDimensionalArr(arr, media_id) {
			//make a copy of array
			let new_arr = [];

			$.each(arr, function (index, i) {
				new_arr[index] = [];
				let count = 0;
				$.each(i, function (key, j) {
					if (j.hasOwnProperty("id")) {
						if(j.id === media_id) {
							//new_arr[index].splice(key, 1);
						}else{
							new_arr[index][count] = j;
							count++;
						}
					}
				}, new_arr);
			}, new_arr);
			return new_arr;
		},
		downloadInterviewMedia: function(current, interview_id, media, e){
			e.stopPropagation();

			const url = './candidate/' + current.id + '/interview/' + interview_id + '/download-media/' + media.id;
			const link = document.createElement('a');
			link.href = url;
			document.body.appendChild(link);
			link.click();
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
		fetchContracts: function() {
			fetch('./contracts', {
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
				this.contracts = res;
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
				offerId = $('#offer_id option:selected').val(),
				cdt = this.current;

			fetch('./candidate/' + this.current.id + '/download-offer', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": token
				},
				method: 'post',
				body: JSON.stringify({ starting_on: startingOn, offer_id: offerId}),
				credentials: "same-origin"
			}).then(function(resp) {
				return resp.blob();
			}).then(function(blob) {
				download(blob, cdt.name + ' - offer letter.pdf');
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
                                // $('.hired').attr('disabled','disabled');
                                // $('#hired_comments').attr('disabled','disabled');
                                // $('#employee_no').attr('disabled','disabled');
                                // this.current.employee_no = employee_no;
                                // this.currentComment = comments;
                                location.reload();
                                // $('#steps a[href="hired"]').tab('show');
							});
						}

					});
                }
            );
		},
		downloadContract: function(){
			var contractId = $('#contract_id option:selected').val(),
			cdt = this.current;

			fetch('./candidate/' + this.current.id + '/download-contract', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": token
				},
				method: 'post',
				body: JSON.stringify({ contract_id: contractId}),
				credentials: "same-origin"
			}).then(function(resp) {
				return resp.blob();
			}).then(function(blob) {
				download(blob, cdt.name + ' - contract.pdf');
			});
		},
		downloadSignedOffer: function(){
			var offerId = $('#offer_id').val(),
			cdt = this.current;

			fetch('./candidate/' + this.current.id + '/download-signed-offer', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": token
				},
				method: 'post',
				body: JSON.stringify({ offer_id: offerId}),
				credentials: "same-origin"
			}).then(function(resp) {
				return resp.blob();
			}).then(function(blob) {
				download(blob, cdt.name + ' - signed offer.pdf');
			});
		},
		downloadSignedContract: function(){
			var contractId = $('#contract_id').val(),
			cdt = this.current;

			fetch('./candidate/' + this.current.id + '/download-signed-contract', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": token
				},
				method: 'post',
				body: JSON.stringify({ contract_id: contractId}),
				credentials: "same-origin"
			}).then(function(resp) {
				return resp.blob();
			}).then(function(blob) {
				download(blob, cdt.name + ' - signed contract.pdf');
			});
		},
		processInterviewForm: function (e) {
			e.preventDefault();
			let vm = this;
			let overallComment = $('#overallComment').val();

			fetch('./candidate/' + vm.current.id + '/update-interview-comment', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": token
				},
				method: 'post',
				body: JSON.stringify({ overallComment: overallComment}),
				credentials: "same-origin"
			})
			.then(function (res) {
				console.log(res);
				if (res.ok == true) {
					alerty.toasts('Operation successful',{'place':'top','time':3500},function(){
						this.currentComment = overallComment;
					});
				}
			});
		}
	},
	created: function () {
		this.fetchCandidates();
	},
	mounted: function() {
		this.fetchOfferLetters();
		this.fetchContracts();
	},
	filters: {
		stageCount:function(people, status){
			if (status == 0 || status === void 0) {
				return people.length;
			}
			else if (status === 1){
				return people.filter(function (person) {
					return (person.status[0].status >= 1 || person.status[0].status === 2 || person.status[0].status === -2);
				}).length;
			}
			else {
				return people.filter(function(person) {
					return person.status[0].status == status
				}).length;
			}
		}
	}
});