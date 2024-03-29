
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// you need this after installing vue-router
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import moment from 'moment'

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '5px'
})

import { Form, HasError, AlertError } from 'vform'
// This is a global compenent, means you can access HasError anywhere in your application
window.formGlobal = Form; //register the Form globally
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


// We can call firtCharCapitalize anywhere in our vue component - global
Vue.filter('firtCharCapitalize', function(text) {
	return text.charAt(0).toUpperCase() + text.slice(1);
})

Vue.filter('myDate', function(createdAt) {
	return moment(createdAt).format('MMMM Do YYYY');
})

// ES6 Modules or TypeScript
import Swal from 'sweetalert2'
window.swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast = Toast;


import jspdf from 'jspdf'
window.jsPDF = jspdf
import 'jspdf-autotable'



// let Fire = new Vue()
// window.fire = Fire
// or this one line
window.Fire = new Vue()

let routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
  { path: '/users', component: require('./components/Users.vue').default },
  { path: '/developer', component: require('./components/Developer.vue').default },
  { path: '/contact-us', component: require('./components/ContactUs.vue').default },
  { path: '/employees', component: require('./components/Employees.vue').default },
  { path: '/new-students', component: require('./components/NewStudents.vue').default },
  { path: '/old-students', component: require('./components/OldStudents.vue').default },
  // { path: '/print-employees', component: require('./components/PrintEmployees.vue').default},
  { path: '/*', component: require('./components/PageNotFound.vue').default },

]

// We have to register our route here
const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
})


import GateAuth from './gate_auth.js'
Vue.prototype.$gateAuth = new GateAuth(window.userGlobal); //userGlobal from master.blade.php


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);
Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);
Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/PageNotFound.vue').default
);

Vue.component('pagination', require('laravel-vue-pagination'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data: {
      search:''
    },
    methods: {
      // searchit() {
      //   Fire.$emit('searching');
      //   console.log('searching...')
      // }

      searchit: _.debounce(() => {
        Fire.$emit('searching');
      }, 2000)
    }
});
