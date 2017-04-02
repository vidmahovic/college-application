import AppView from './components/App.vue'
import LoginView from './components/Login.vue'
import NotFoundView from './components/404.vue'

import AdminView from './components/admin/Dashboard.vue'

import ReferentView from './components/referent/Dashboard.vue'

import StudentView from './components/student/Dashboard.vue'

const routes = [
	{
		path: '/login',
		component: LoginView,
		
	},
	{
		path: '/',
		component: AppView,
		name: 'Root',
		meta: {description: 'Root'}
	},
	{
		path: '/admin',
		component: AdminView,
		name: 'Admin',
		meta: {description: 'Admin Dashboard'}
	},
	{
		path: '/referent',
		component: ReferentView,
		name: 'Referent',
		meta: {description: 'Referent Dashboard'}
	},
	{
		path: '/student',
		component: StudentView,
		name: 'Student',
		meta: {description: 'Student Dashboard'}
	},
	{
    // not found handler
    path: '*',
    component: NotFoundView
  }
]

export default routes