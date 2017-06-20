require('./bootstrap');
import router from './routes';


// Vue.component('example', require('./components/Example.vue'));
//Vue.component('seat', require('./components/Seat.vue'));
Vue.component('seat-display', require('./components/Seat_display.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('show-alert', require('./components/Alert.vue'));
Vue.component('high-light', require('./components/Highlighter.vue'));
Vue.component('loader', require('./components/Loader.vue'));
//const app = new Vue({
const app = new Vue({
    el: '#app',
    
    router
});
