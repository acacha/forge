// import {UserProfile} from 'acacha-users' -> Custom modified acacha users profile
import UserProfile from './users/user-profile/UserProfileComponent.vue'
import AdminlteVue from 'adminlte-vue'
import { config } from './config/forge'
import Vue from 'vue'

// Servers
Vue.component('ask-server-permission', require('./forge/AskServerPermissionComponent.vue'))
Vue.component('laravel-forge-servers', require('./forge/LaravelForgeServersComponent.vue'))

Vue.use(AdminlteVue)

// Profile
Vue.component('user-profile', UserProfile)

window.acacha_forge = {}
window.acacha_forge.config = config
