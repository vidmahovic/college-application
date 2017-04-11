import AppView from './components/App.vue'
import LoginView from './components/Login.vue'
import NotFoundView from './components/404.vue'

import AdminView from './components/Admin.vue'
import AdminDashboard from './components/admin/Dashboard.vue'

import ReferentView from './components/Referent.vue'
import ReferentDashboard from './components/referent/Dashboard.vue'

import StudentView from './components/Student.vue'
import StudentDashboard from './components/student/Dashboard.vue'
import StudentApplication from './components/student/Application.vue'
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
		/*name: 'Admin',*/
		meta: {description: 'Admin /'},
		children: [
			{
				path: '',
				component: AdminDashboard,
				name: 'AdminDashboard',
				meta: {description: 'AdminDashboard'}
      		}
		]
	},
	{
		path: '/referent',
		component: ReferentView,
		/*name: 'Referent',*/
		meta: {description: 'Referent /'},
		children: [
			{
				path: '',
				component: ReferentDashboard,
				name: 'ReferentDashboard',
				meta: {description: 'ReferentDashboard'}
      		}
		]
	},
	{
		path: '/student',
		component: StudentView,
		/*name: 'Student',*/
		meta: {description: 'Student /'},
		children: [
			{
				path: '',
				component: StudentDashboard,
				name: 'StudentDashboard',
				meta: {description: 'StudentDashboard'}
      		}, 
      		{
		        path: '/application',
		        component: StudentApplication,
		        name: 'StudentApplication',
		        meta: {description: 'StudentApplication'}
	      	}
		]
	},
	{
    // not found handler
    path: '*',
    component: NotFoundView
  }
];

export default routes
