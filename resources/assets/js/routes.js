import AppView from './components/App.vue'
import LoginView from './components/Login.vue'
import NotFoundView from './components/404.vue'

import AdminView from './components/Admin.vue'
import AdminDashboard from './components/admin/Dashboard.vue'
import AdminRegistracija from './components/admin/Registracija.vue'

import ReferentView from './components/Referent.vue'
import ReferentDashboard from './components/referent/Dashboard.vue'

import StudentView from './components/Student.vue'
import StudentDashboard from './components/student/Dashboard.vue'
import StudentApplication from './components/student/Application.vue'

import VpisnaSluzbaView from './components/vpisnaSluzba.vue'
import VpisnaSluzbaDashboard from './components/vpisnaSluzba/Dashboard.vue'
import VpisnaSluzbaProgrami from './components/vpisnaSluzba/Programi/Programi.vue'
import VpisnaSluzbaProgramiUrejanje from './components/vpisnaSluzba/Programi/Urejanje.vue'
import VpisnaSluzbaProgramiUstvari from './components/vpisnaSluzba/Programi/Ustvari.vue'

import PregledVpisanih from './components/vpisnaSluzba/Programi/PregledVpisanih.vue'
import Sprejeti from './components/vpisnaSluzba/Programi/Sprejeti.vue'
import vpisnaSluzbaIO from './components/vpisnaSluzba/IO/IO.vue'
import Calculation from './components/vpisnaSluzba/Programi/Calculation.vue'

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
      },
			{
				path: '/admin/registracija',
				component: AdminRegistracija,
				name: 'AdminRegistracija',
				meta: {desciption: 'AdminRegistracija'}
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
      },
			{
				path: '/referent/pregled_vpisanih',
				component: PregledVpisanih,
				name: 'PregledVpisanih'
			},
			{
				path: '/referent/sprejeti',
				component: Sprejeti,
				name: 'Sprejeti'
			}
		]
	},
	{
		path: '/enrollment_service',
		component: VpisnaSluzbaView,
		/*name: 'vpisnaSluzba',*/
		meta: {description: 'Vpisna sluzba /'},
		children: [
			{
				path: '',
				component: VpisnaSluzbaDashboard,
				name: 'VpisnaSluzbaDashboard',
				meta: {description: 'VpisnaSluzbaDashboard'}
      		},
			{
				path: '/enrollment_service/programi',
				component: VpisnaSluzbaProgrami,
				name: 'VpisnaSluzbaProgrami',
				meta: {description: 'VpisnaSluzbaProgrami'}
			},
			{
				path: '/enrollment_service/programi/ustvari',
				component: VpisnaSluzbaProgramiUstvari,
				name: 'VpisnaSluzbaProgramiUstvari'
			},
			{
				path: '/enrollment_service/programi/:id',
				component: VpisnaSluzbaProgramiUrejanje,
				name: 'VpisnaSluzbaProgramiUrejanje'
			},
			{
				path: '/enrollment_service/:id/prijavljeni',
				component: PregledVpisanih,
				name: 'PregledVpisanih'
			},
			{
				path: '/enrollment_service/:id/sprejeti',
				component: Sprejeti,
				name: 'Sprejeti'
			},
			{
				path: '/enrollment_service/prijavljeni',
				component: PregledVpisanih,
				name: 'PregledVpisanih1'
			},
			{
				path: '/enrollment_service/sprejeti',
				component: Sprejeti,
				name: 'Sprejeti1'
			},
			{
				path: '/enrollment_service/io',
				component: vpisnaSluzbaIO,
				name: 'vpisnaSluzbaIO'
			},
			{
				path: '/enrollment_service/calculation/:id',
				component: Calculation,
				name: 'Calculation'
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
