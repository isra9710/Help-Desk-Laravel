/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./pages/dashboard');
require('./pages/dashboard2');
require('./pages/dashboard3');
require('./jsgrid.min');
/*require('./select2.full.min');
require('./jquery.bootstrap-duallistbox.min');
require('./moment.min');
require('./jquery.inputmask.bundle.min');
require('./daterangepicker');
require('./bootstrap-colorpicker.min');
require('./tempusdominus-bootstrap-4.min');
require('./bootstrap-switch.min');*/
require('./demo');
require('./adminlte');
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
