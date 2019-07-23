import {on} from 'delegated-events';

require('parsleyjs');
window.Vue = require('vue/dist/vue.common.js');
Vue.config.productionTip = false;

Vue.prototype.window = window;

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

Vue.component('pagination', require('laravel-vue-pagination'));

if($('#my-vacancies').length){
    $("input[name='_method']").val('POST');
}

var vm = new Vue({
	el: "#my-vacancies",
	data: {},
	computed: {},
	methods: {
        applyVacancy: function(recruitment_id, job_title, event){
            //disable action till page is fully loaded
            if(event.target.className != 'isDisabled') {
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
		}
	},
	created: function () {},
	mounted: function() {},
	filters: {}
});
