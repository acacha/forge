<template>
    <div>
        <adminlte-vue-flash :message="message"></adminlte-vue-flash>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Servers</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="users">User</label>
                    <multiselect id="users" v-model="user" :options="users" :custom-label="customUsersLabel"
                                 @select="userHasBeenSelected"
                                 placeholder="Select user" :disabled="disabled" :loading="loadingUsers"></multiselect>
                </div>
                <div class="form-group">
                    <label>Servers</label>


                    <table class="table table-bordered table-striped table-hover">
                        <tbody><tr>
                            <th style="width: 10px">#</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Forge id</th>
                            <th>State</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                        <tr v-for="(server, index) in servers">
                            <td>{{ index + 1 }}</td>
                            <td>{{ server.id }}</td>
                            <td>{{ server.name }}</td>
                            <td>{{ server.forge_id }}</td>
                            <td>{{ server.state }}</td>
                            <td>{{ server.created_at }}</td>
                            <td>{{ server.updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button @click="askPermission( server )" :disabled='serverBeingAsked == server.id' v-if="server.state === 'pending'" type="button" class="btn btn-success">
                                        <i class="fa fa-refresh fa-spin fa-lg" v-if="serverBeingAsked == server.id"></i> Ask permission again</button>
                                    <button @click="unassign( server )" :disabled='serverBeingUnassigned == server.id' type="button" class="btn btn-danger">
                                        <i class="fa fa-refresh fa-spin fa-lg" v-if="serverBeingUnassigned == server.id"></i> Unassign
                                    </button>
                                    <button @click="validate( server )" :disabled='serverBeingValidated == server.id' v-if="server.state === 'pending'" type="button" class="btn btn-info">
                                        <i class="fa fa-refresh fa-spin fa-lg" v-if="serverBeingValidated == server.id"></i> Validate</button>
                                    <button @click="unvalidate( server )" :disabled='serverBeingUnvalidated == server.id' v-else type="button" class="btn btn-danger">
                                        <i class="fa fa-refresh fa-spin fa-lg" v-if="serverBeingUnvalidated == server.id"></i> Unvalidate</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-if="loadingServers" class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>

<script>

  import Multiselect from 'vue-multiselect'

  export default {
    components: { Multiselect },
    data () {
      return {
        loadingUsers: false,
        loadingServers: false,
        serverBeingUnassigned : null,
        serverBeingValidated : null,
        serverBeingUnvalidated: null,
        serverBeingAsked: null,
        disabled:false,
        user: null,
        server: null,
        users: [],
        servers: [],
        message:'',
      }
    },
    watch: {
      user() {
        this.updateServers()
      }
    },
    methods: {
      removeServer: function (server) {
        this.servers.splice(this.servers.indexOf(server), 1)
      },
      unvalidateServer: function (server) {
        this.servers[this.servers.indexOf(server)].state = 'pending'
      },
      validateServer: function (server) {
        this.servers[this.servers.indexOf(server)].state = 'valid'
      },
      askPermission( server ) {
        this.serverBeingAsked = server.id
        let url = '/api/v1/users/' + this.user.id + '/servers/' + server.id + '/ask_permission';
        axios.post(url).then((response) => {
          this.$events.$emit('flashMessage', 'success' ,'The notifications has been sended again!');
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('flashMessage', 'error' ,error.response.data.message);
        }).then( () => {
          this.serverBeingAsked = null
        })
      },
      unassign(server) {
        this.serverBeingUnassigned = server.id
        let url = '/api/v1/users/' + this.user.id + '/servers/' + server.forge_id
        axios.delete(url).then((response) => {
          this.removeServer(server)
          this.$events.$emit('flashMessage', 'success' ,'Server unassigned correctly!');
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('flashMessage', 'error' ,error.response.data.message);
        }).then( () => {
          this.serverBeingUnassigned = null
        })
      },
      validate(server) {
        this.serverBeingValidated = server.id
        let url = '/api/v1/users/' + this.user.id + '/servers/' + server.id + '/validate'
        axios.post(url).then((response) => {
          this.validateServer(server)
          this.$events.$emit('flashMessage', 'success' ,'Server validated correctly!');
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('flashMessage', 'error' ,error.response.data.message);
        }).then( () => {
          this.serverBeingValidated = null
        })
      },
      unvalidate(server) {
        this.serverBeingUnvalidated = server.id
        let url = '/api/v1/users/' + this.user.id + '/servers/' + server.id + '/validate'
        axios.delete(url).then((response) => {
          this.unvalidateServer(server)
          this.$events.$emit('flashMessage', 'success' ,'Server unvalidated correctly!');
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('flashMessage', 'error' , error.response.data.message);
        }).then( () => {
          this.serverBeingUnvalidated = null
        })
      },
      customUsersLabel({ name, email , id}) {
        return `${name} - ${email} - ${id}`
      },
      updateServers() {
        this.servers = []
        this.fetchServers()
      },
      fetchServers() {
        let url = '/api/v1/users/' + this.user.id + '/servers'
        this.loadingServers = true
        axios.get(url).then((response) => {
          this.servers = response.data
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('flashMessage', 'error' ,error.response.data.message);
        }).then( () => {
          this.loadingServers = false
        })
      },
      fetchUsers() {
        let url = '/api/v1/users_with_logged_user'
        axios.get(url).then((response) => {
          this.users = response.data.users
          this.user = response.data.logged
          this.fetchServers()
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('flashMessage', 'error' ,error.response.data.message);
        }).then( () => {
          this.loadingUsers = false
        })
      },
      userHasBeenSelected(user) {
        this.$emit('userSelected',user)
      }
    },
    mounted() {
      this.fetchUsers()
    }
  }

</script>