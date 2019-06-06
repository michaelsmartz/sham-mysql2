window.Vue = require('vue/dist/vue.common.js');
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
//import BootstrapTable from 'vue-bootstrap-table';

Vue.component('date-picker', {
	template: '  <div><flat-pickr v-model="date" class="form-control" required="required" ></flat-pickr></div>',
	data: function() {
		return {
			date: null
		}
	},
    components: {
      flatPickr
    }
});

Vue.component('wenzhixin-bs-table', {
	template: '<bootstrap-table :columns="columns" :data="data" :options="options"></bootstrap-table>',
	data: function() {
		return {
			columns: [
				{
				  title: 'Item ID',
				  field: 'id'
				},
				{
				  field: 'name',
				  title: 'Item Name'
				}, {
				  field: 'price',
				  title: 'Item Price'
				}
			],
			data: [
				{
				  "id": 0,
				  "name": "Item 0",
				  "price": "$0"
				},
				{
				  "id": 1,
				  "name": "Item 1",
				  "price": "$1"
				},
				{
				  "id": 2,
				  "name": "Item 2",
				  "price": "$2"
				},
				{
				  "id": 3,
				  "name": "Item 3",
				  "price": "$3"
				}
			],
			options: {
	  
			}
		}
	},
    components: {
		BootstrapTable
    }
});

var vm = new Vue({
	el: "#test-zone",
	data: {
		columns: [
			{
			  title: 'Item ID',
			  field: 'id'
			},
			{
			  field: 'name',
			  title: 'Item Name'
			}, {
			  field: 'price',
			  title: 'Item Price'
			}
		  ],
		  data: [
			{
			  "id": 0,
			  "name": "Item 0",
			  "price": "$0"
			},
			{
			  "id": 1,
			  "name": "Item 1",
			  "price": "$1"
			},
			{
			  "id": 2,
			  "name": "Item 2",
			  "price": "$2"
			},
			{
			  "id": 3,
			  "name": "Item 3",
			  "price": "$3"
			},
			{
			  "id": 4,
			  "name": "Item 4",
			  "price": "$4"
			},
			{
			  "id": 5,
			  "name": "Item 5",
			  "price": "$5"
			},
			{
			  "id": 6,
			  "name": "Item 6",
			  "price": "$6"
			},
			{
			  "id": 7,
			  "name": "Item 7",
			  "price": "$7"
			},
			{
			  "id": 8,
			  "name": "Item 8",
			  "price": "$8"
			},
			{
			  "id": 9,
			  "name": "Item 9",
			  "price": "$9"
			}
		  ],
		  options: {
	  
		  }
	  
	}
});