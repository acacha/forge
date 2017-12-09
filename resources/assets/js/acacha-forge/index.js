// // Servers
Vue.component('ask-server-permission', require('./forge/AskServerPermissionComponent.vue'));
Vue.component('laravel-forge-servers', require('./forge/LaravelForgeServersComponent.vue'));

// import {UserProfile} from 'acacha-users' -> Custom modified acacha users profile
import UserProfile from './users/user-profile/UserProfileComponent.vue'

import AdminlteVue from 'adminlte-vue'
Vue.use(AdminlteVue)

//Profile
Vue.component('user-profile', UserProfile);

import { config } from './config/forge'

window.acacha_forge = {}
window.acacha_forge.config = config


