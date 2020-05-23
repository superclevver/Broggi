/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('Incidencias', require('./components/Incidencias.vue').default);
Vue.component('incidenciesasignades', require('./components/IncidenciesAsignades.vue').default);
Vue.component('recursos-mobils', require('./components/RecursosMobils.vue').default);
Vue.component('alertants', require('./components/Alertants.vue').default);
Vue.component('menu1-cards', require('./components/Menu1Cards.vue').default);
Vue.component('menu2-cards', require('./components/Menu2Cards.vue').default);
Vue.component('menuadmin-cards', require('./components/MenuAdminCards.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('header-menu', require('./components/HeaderMenu.vue').default);
Vue.component('ajuda', require('./components/Ajuda.vue').default);
Vue.component('header-plantilla', require('./components/HeaderPlantilla.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
