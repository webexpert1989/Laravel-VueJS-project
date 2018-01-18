// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Lang from 'vuejs-localization'
import VueClickoutside from 'vue-clickoutside'
import VueFormWizard from 'vue-form-wizard'
import VeeValidate from 'vee-validate'
import draggable from 'vuedraggable'
import VueScrollbar from 'vue2-scrollbar'
import Modal from 'vue2-flexible-modal';
import VueSweetAlert from 'vue-sweetalert'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import "vue2-scrollbar/dist/style/vue2-scrollbar.css"
import VueProgressBar from 'vue-progressbar'
import App from './App'
import router from './router'

/* eslint-disable no-new */

Lang.requireAll(require.context('./lang', true, /\.js$/))
Vue.use(Lang);
Vue.use(VueClickoutside);
Vue.use(VueFormWizard);
Vue.use(draggable);
Vue.use(VueScrollbar);
Vue.use(Modal);
Vue.use(VueSweetAlert);
Vue.use(VeeValidate, {fieldsBagName: 'formFields'})
Vue.component('draggable', Vue.extend(draggable))
Vue.component('vue-scrollbar', Vue.extend(VueScrollbar))
Vue.component('modal', Vue.extend(Modal))
Vue.use(VueProgressBar, progressbar_options)

const progressbar_options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '8px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'left',
  inverse: false
}

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: {	App }
})

