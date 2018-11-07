
require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router'
import Vuex from 'vuex'
import VuexStore from './states'
import routes from './routes'
import Loader from './components/Loader'

Vue.use(Vuex)
Vue.use(VueRouter)

const router = new VueRouter ({
    routes
})

//METODO RODA ANTES DE CADA UMA DAS ROTAS, VERIFICANDO SE REQUER AUTORIZAÇÃO:
router.beforeEach((to, from, next) => {
    let requiresAuth = to.meta.requiresAuth || false;

    if (requiresAuth) {
       return window.axios.get('/api/v1/users/me').then((res) => {
           if (res.data.id === undefined) {
               return next({path: 'login'});
           }
           return next();
       })
    }
    return next();
})

const store = new Vuex.Store(VuexStore)

const app = new Vue({
    el: '#app',
    components: {
        loader: Loader
    },
    template: '<div><router-view class="container"></router-view><loader></loader></div>',
    router,
    store
});
