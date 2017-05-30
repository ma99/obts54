require('./bootstrap');
import router from './routes';

// Vue.component('example', require('./components/Example.vue'));
//Vue.component('seat', require('./components/Seat.vue'));
Vue.component('seat-display', require('./components/Seat_display.vue'));

const app = new Vue({
    el: '#app',

    router
});
