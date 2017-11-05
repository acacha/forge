// Register components
Vue.component('ask-server-permission', require('./forge/AskServerPermissionComponent.vue'));
Vue.component('laravel-forge-servers', require('./forge/LaravelForgeServersComponent.vue'));


import { config } from './config/relationships'

window.acacha_forge = {}
window.acacha_forge.config = config

import AdminlteVue from 'adminlte-vue'
Vue.use(AdminlteVue)
