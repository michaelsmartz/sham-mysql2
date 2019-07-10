import {on} from 'delegated-events';
window.Vue = require('vue/dist/vue.common.js');
Vue.config.productionTip = false;

Vue.prototype.window = window;

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

var vm = new Vue({
	el: "#my-vacancies",
	data: {
		button: 'Apply'
	},
	computed: {},
	methods: {
        applyVacancy: function(recruitment_id, job_title){
            var vm = this;

            alerty.confirm(
                "Are you sure you want to <strong class='text-danger'> apply </strong> for <strong class='text-danger'>" + job_title + "</strong> position?<br>", {
                    okLabel: '<span class="text-danger">Yes</span>',
                    cancelLabel: 'No'
                },
                function () {
                    fetch('./my-vacancies/' + recruitment_id + '/apply', {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'post',
                        body: JSON.stringify({ recruitment_id: recruitment_id}),
                        credentials: "same-origin"
                    })
					.then(function (res) {
						if (res.ok == true) {
							alerty.toasts('Operation successful',{'place':'top','time':3500},function(){
                                // location.reload();
							});
						}

					});
                }
            );
		}
	},
	created: function () {},
	mounted: function() {},
	filters: {}
});
