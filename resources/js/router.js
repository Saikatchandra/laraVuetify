import Vue from 'vue';
import VueRouter from 'vue-router';
import LoginComponent from './components/LoginComponent';
import AdminComponent from './components/AdminComponent';
import RoleComponent from './components/RoleComponent';
import UserComponent from './components/UserComponent';
Vue.use(VueRouter)



const routes = [
 {
     path: '/',
     redirect:'/login'
 },
 {
     path: '/login',
     component: LoginComponent,
     name: 'Login'
 },
 {
     path: '/admin',
     component: AdminComponent,
     name: 'Admin',
     children:[
      {
      	path: 'roles',
      	component:RoleComponent,
      	name: 'Roles'
      }, {
        path: 'users',
        component:UserComponent,
        name: 'Users'
      },
     ],

     beforeEnter: (to, from, next) => {
       axios.get('api/verify')
         .then(res => next())
         .catch(err => next('/login'))
      }

     // beforeEnter: (to, from, next) => {
     //    if(localStorage.getItem('token')){
     //    	next();
     //    } else {
     //    	next('/login');
     //    }
     //  }

 },
]



const router = new VueRouter({routes})

//global route which check token for all route before go
router.beforeEach((to, from, next) => {
	const token = localStorage.getItem('token') || null
 	window.axios.defaults.headers['Authorization'] = "Bearer " + token;
 	next();
})

export default router