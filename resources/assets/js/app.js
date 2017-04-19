/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

import routes from './routes'
import AppView from './components/App.vue'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 * We will use VueRouter of navigation our SPA application.
 * Mapping from urls to Vue Components is done in routes.js and we
 * just import it here
 */
import vSelect from 'vue-select'

import Datepicker from 'vuejs-datepicker'
Vue.use(VueRouter)
Vue.use(VueResource)

Vue.component('v-select', vSelect)
Vue.component('datatable',require('../../../node_modules/vuejs-datatable/src/vue-datatable.vue'))
Vue.component('datepicker', Datepicker)



Vue.http.interceptors.push(function(request, next) {

	console.log("http interceptors")
	//request.headers['Authorization'] = 'Bearer: ' + localStorage.getItem('token')
  	request.headers.set('Authorization', 'Bearer ' + localStorage.getItem('token'));
  	console.log(request);
		
  	next();
});

const router = new VueRouter({
	base: __dirname,
	routes: routes
});

const app = new Vue({
  el: '#college-app',
  router: router,
  render: h => h(AppView)
});
