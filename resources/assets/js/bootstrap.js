import asyncJS from 'async-js';
import Pace from 'pace-progress';
import ready from '@benjaminreid/ready.js';

import draggable from 'jquery-ui/ui/widgets/draggable';
import droppable from 'jquery-ui/ui/widgets/droppable';
import resizable from 'jquery-ui/ui/widgets/resizable';
import datepicker from 'jquery-ui/ui/widgets/datepicker';

import params from 'url-search-params-update';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
	const domLoaded = require('dom-loaded');
	const elementReady = require('element-ready');

	window.$ = window.jQuery = global.$ = global.jQuery = require('jquery');
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	/*
	window.Util = require('exports-loader?Util!bootstrap/js/dist/util'); // eslint-disable-line
	window.Button = require('exports-loader?Button!bootstrap/js/dist/button'); // eslint-disable-line
	window.Dropdown = require('exports-loader?Dropdown!bootstrap/js/dist/dropdown'); // eslint-disable-line
	window.Tooltip = require('exports-loader?Tooltip!bootstrap/js/dist/tooltip'); // eslint-disable-line
	window.Popover = require('exports-loader?Popover!bootstrap/js/dist/popover'); // eslint-disable-line
	window.Modal = require('exports-loader?Modal!bootstrap/js/dist/modal'); // eslint-disable-line
	*/

	/*
	window.Bootstrap = require('bootstrap-sass');
	require("bootstrap-sass/assets/javascripts/bootstrap/button");
	require("bootstrap-sass/assets/javascripts/bootstrap/modal");
	require("bootstrap-sass/assets/javascripts/bootstrap/tooltip");
	require("bootstrap-sass/assets/javascripts/bootstrap/popover");
	require("bootstrap-sass/assets/javascripts/bootstrap/dropdown");
	*/


	require('bootstrap-confirmation2/bootstrap-confirmation.js');

	domLoaded.then(function() {
		console.log('DOM is loaded');
		$('[data-toggle=offcanvas]').click(function() {
			$('.row-offcanvas').toggleClass('active');
		});
	});

	window.paceOptions = {
		document: true,
		ghostTime: 60,
		ajax: {
			trackMethods: ['GET', 'POST', 'PUT', 'DELETE'],
			/*ignoreURLs: ["{{URL::to('refresh-csrf')}}", "getHeadcountData",
				"getQAProductsData", "getQALastFiveDaysData",
				"getCourseData", "getAssetData", "questionnaireparticipants", "questionnaireparticipants/*"
			]*/
		}
	};

	Pace.on('start', function (e) {
		$('#page-container').addClass('no-click semi-opaque');
	});
	Pace.on('restart', function (e) {
		$('#page-container').addClass('no-click semi-opaque');
	});
	Pace.on('done', function (e) {
		$('#page-container').removeClass('no-click semi-opaque');
	});

	//window._ = require('lodash');
	window.asyncJS = global.asyncJS = asyncJS;

	// toggle function
	$.fn.clickToggle = function (f1, f2) {
		return this.each(function () {
			var clicked = false;
			$(this).bind('click', function () {
				if (clicked) {
					clicked = false;
					return f2.apply(this, arguments);
				}
				clicked = true;
				return f1.apply(this, arguments);
			});
		});
	};

} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
/*
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
*/

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

/*
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
*/

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

/*
import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-pusher-key'
});
*/