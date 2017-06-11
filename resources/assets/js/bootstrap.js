
window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');
require('bootstrap-datepicker');

require('jquery-slimscroll');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);


window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// window.axios.defaults.headers.common = {
//     'X-CSRF-TOKEN': window.Laravel.csrfToken,
//     'X-Requested-With': 'XMLHttpRequest'
// };

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}



import Form from './utilities/Form';
window.Form = Form;

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

	window.Echo = new Echo({
	    broadcaster: 'pusher',
	    key: 'cb975329f18a7dd87b00'	    
	});
	

