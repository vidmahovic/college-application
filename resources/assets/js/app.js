/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueRouter from 'vue-router'

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
Vue.use(VueRouter);


const router = new VueRouter({
	base: __dirname,
	routes: routes
});

const app = new Vue({
  el: '#college-app',
  router: router,
  render: h => h(AppView)
});
