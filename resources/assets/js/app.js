import router from './routes'
import App from './components/App'
import {APP_ENV, APP_URL,SHOW_ERROR_TIME} from './config'
import VueResource from 'vue-resource'
// import KeenUI from 'keen-ui'

// bootstrap js
window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');
require('./scripts.js');
    

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue')

window.Vue.config.productionTip = false

//axios
/*
window.axios = require('axios');  
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};
*/

Vue.use(VueResource)
//Vue.use(KeenUI)



Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementsByName('csrf-token')[0].getAttribute('content')
Vue.http.headers.common['Authorization'] = 'bearer ' + sessionStorage.getItem('id_token')
Vue.http.options.root = APP_URL

Vue.http.interceptors.push(function(request, next) {
    next(function(response) {
        if (response.status == 401 && response.body.message == 'Token has expired') {
            router.push({ name: 'home' })
        }
    })
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



const app = new Vue({
	el: '#app',
	router,
	template: '<App/>',
	components: { App },
    data : {
        errors: {},
    },
    watch:{
       errors: function(val,oldVal){
           if(val){
               if(Object.keys(val).length > 0)
               setTimeout(() => {
                    this.errors = {};
                }, SHOW_ERROR_TIME * 1000);
           }
       }, 
        
    }
}) ;
   