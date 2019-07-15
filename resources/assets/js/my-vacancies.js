import {on} from 'delegated-events';

require('parsleyjs');
window.Vue = require('vue/dist/vue.common.js');
Vue.config.productionTip = false;

Vue.prototype.window = window;

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

var vm = new Vue({
	el: "#my-vacancies",
	data: {},
	computed: {},
	methods: {
        applyVacancy: function(recruitment_id, job_title){
            var vm = this;

            alerty.confirm(
                "Are you sure you want to <strong class='text-danger'> apply </strong> for <strong class='text-danger'>" + job_title + "</strong> position?<br>", {
                    okLabel: '<a class="text-danger" href="#light-modal">Yes</a>',
                    cancelLabel: 'No'
                },
                function () {
                    window.loadUrl('my-vacancies/' + recruitment_id + '/salary-expectation');
                }
            );
		}
	},
	created: function () {},
	mounted: function() {},
	filters: {}
});
