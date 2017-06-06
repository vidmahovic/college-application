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
import VeeValidate from 'vee-validate';

Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(VeeValidate)


Vue.component('v-select', vSelect)
Vue.component('datatable',require('../../../resources/lib/vuejs-datatable/src/vue-datatable.vue'))
Vue.component('datepicker', Datepicker)


//za $emit in $on
//export const eventBus = new Vue();

Vue.component('edit-program', {
    template: '<button class="btn btn-xs btn-warning" @click="goToUpdatePage">Podrobno</button>',
    props: ['row'],
		methods: {
			goToUpdatePage: function(row){
				this.$root.programData = this.row;
				//ker ne delata $emit $on sem uproabil $root
				//this.$emit('programdata', this.row);
				this.$router.push("/enrollment_service/programi/"+this.row.id);
	    }
		}
})

Vue.component('ability_test_input', {
    template: '<input class="form-control" type="text" @click="goToUpdatePage" />',
    props: ['row'],
		methods: {
			goToUpdatePage: function(row){
	    }
		}
})

Vue.component('points_calculation', {
    template: '<button class="btn btn-xs btn-warning" @click="goToUpdatePage">Podrobno</button>',
    props: ['row'],
		methods: {
			goToUpdatePage: function(row){

				this.$root.userApplicationPoints = this.row;

				this.$router.push("/enrollment_service/calculation/"+this.row.id)
	    }
		}
})


Vue.http.interceptors.push(function(request, next) {


	//request.headers.set('Content-Type','multipart/form-data');
	request.headers.set('Authorization', 'Bearer ' + localStorage.getItem('token'));
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
