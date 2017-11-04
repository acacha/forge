<template>
    <div>
        <adminlte-vue-alert></adminlte-vue-alert>
        <div class="box box-primary">
            <form method="post" @submit.prevent="submit" @keydown="clearErrors($event.target.name)">
                <div class="box-header with-border">
                    <h3 class="box-title">Please select the server you want to ask for permissions:</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="servers">Users</label>
                        <multiselect id="users" v-model="user" :options="users" :custom-label="customUsersLabel"
                                     @select="userHasBeenSelected"
                                     placeholder="Select user" :disabled="disabled" :loading="loadingUsers"></multiselect>
                    </div>
                    <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('server_id') }">
                        <transition name="fade">
                            <label class="help-block" v-if="form.errors.has('server_id')" v-text="form.errors.get('server_id')"></label>
                            <label for="givenName" v-else>Servers</label>
                        </transition>
                        <multiselect id="servers" v-model="server" :options="servers" :custom-label="customServersLabel"
                                     @select="serverHasBeenSelected"
                                     placeholder="Select server" :disabled="disabled" :loading="loadingServers"></multiselect>
                    </div>
                </div>
                <div class="box-footer vertical-align-content">
                    <button type="submit" class="btn btn-primary" :disabled="form.submitting || form.errors.any()">
                        <template v-if="form.submitting"><i class="fa fa-refresh fa-spin"></i> Asking</template>
                        <template v-else>Ask</template>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    .vertical-align-content {
        display:flex;
        align-items:center;
        justify-content: flex-end
    }
</style>

<script>

  import Form from 'acacha-forms'
  import Multiselect from 'vue-multiselect'

  export default {
    components: { Multiselect },
    data () {
      return {
        todo: false,
        loadingUsers: false,
        loadingServers: false,
        disabled:false,
        user: null,
        server: null,
        users: [],
        servers: [],
        form: new Form( { server_id: ''})
      }
    },
    methods: {
      submit() {
        let url = '/api/v1/users/' + this.user.id + '/servers'
        this.form.post(url)
          .then(response => {
            console.log(response.data)
          })
          .catch(error => {
            console.log('Register error: ' + error)
          })
      },
      clearErrors (name) {
        this.form.errors.clear(name)
      },
      customServersLabel({ name, id}) {
        return `${name} - ${id}`
      },
      customUsersLabel({ name, email , id}) {
        return `${name} - ${email} - ${id}`
      },
      fetchServers() {
        let url = '/api/v1/servers'
        this.loadingServers = true
        axios.get(url).then((response) => {
          this.servers = response.data
        }).catch((error) => {
          console.log(error)
        }).then( () => {
          this.loadingServers = false
        })
      },
      fetchUsers() {
        let url = '/api/v1/users_with_logged_user'
        axios.get(url).then((response) => {
          this.users = response.data.users
          this.user = response.data.logged
        }).catch((error) => {
          console.log(error)
        }).then( () => {
          this.loadingUsers = false
        })
      },
      serverHasBeenSelected(server) {
        this.server = server
        this.form.server_id = server.id
        this.clearErrors('server_id')
        this.$emit('serverSelected',server)
      },
      userHasBeenSelected(user) {
        this.$emit('userSelected',user)
      }
    },
    mounted() {
      this.fetchServers()
      this.fetchUsers()
    }
  }

</script>