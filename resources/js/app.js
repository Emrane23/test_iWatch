/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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
Vue.component('posts', require('./components/PostsComponent.vue').default);
Vue.component('global-home', require('./components/GlobalHomeComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('register', require('./components/RegisterComponent.vue').default);
Vue.component('login', require('./components/LoginComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import router from './routes/routes';
import Vuex from 'vuex';
import Axios from 'axios';
Vue.use(Vuex)
const store = new Vuex.Store({
    state:{
        userToken: null
    }, 
    getters:{
        isLogged(state){
            return !!state.userToken
        }
    },
    mutations:{
        setUserToken(state, userToken){
            state.userToken = userToken ;
            localStorage.setItem('userToken', JSON.stringify(userToken));
            axios.defaults.headers.common.Authorization = `bearer ${userToken}`
        }, 
        removeUserToken(state){
            state.userToken = null ;
            localStorage.removeItem('userToken')
        }
    },
    actions:{
        RegisterUser({commit},parametres){
            axios.post(('/api/register',parametres)).then( res => {
                console.log(res)
                commit('setUserToken', parametres)
            }).catch( err => {
                console.log(err)
            })
        },
        LoginUser({commit},parametres){
            axios.post(('/api/login',parametres)).then( res => {
                console.log(res)
                commit('setUserToken', parametres)
            }).catch( err => {
                console.log(err)
            })
        }
    }
})
const app = new Vue({
    el: '#app',
    router , 
    store
});
