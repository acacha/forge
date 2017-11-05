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
                            <th>Name</th>
                            <th>Forge id</th>
                            <th>State</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                        <tr v-for="(server, index) in servers">
                            <td>{{ index + 1 }}</td>
                            <td>{{ server.name }}</td>
                            <td>{{ server.forge_id }}</td>
                            <td>{{ server.state }}</td>
                            <td>{{ server.created_at }}</td>
                            <td>{{ server.updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button v-if="server.state === 'pending'" type="button" class="btn btn-success">Ask permission again</button>
                                    <button type="button" class="btn btn-danger">Unassign</button>
                                    <button type="button" class="btn btn-info">Aprove</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!--<vuetable ref="vuetable"-->
                              <!--:api-url="apiUrl"-->
                              <!--:fields="fields"-->
                              <!--:http-options="httpOptions"-->
                              <!--:css="css.table"-->
                    <!--&gt;</vuetable>-->

                </div>
            </div>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>

<script>

  import Multiselect from 'vue-multiselect'

  import Vuetable from 'vuetable-2/src/components/Vuetable'
  import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
  import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'

  export default {
    components: {
      Multiselect,
      Vuetable,
      VuetablePagination,
      VuetablePaginationInfo,
    },
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
        css: {
          table: {
            tableClass: 'table table-bordered table-striped table-hover',
            ascendingIcon: 'glyphicon glyphicon-chevron-up',
            descendingIcon: 'glyphicon glyphicon-chevron-down'
          },
          pagination: {
            wrapperClass: 'pagination',
            activeClass: 'active',
            disabledClass: 'disabled',
            pageClass: 'page',
            linkClass: 'link',
            icons: {
              first: '',
              prev: '',
              next: '',
              last: '',
            },
          },
          icons: {
            first: 'glyphicon glyphicon-step-backward',
            prev: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            last: 'glyphicon glyphicon-step-forward',
          },
        },
        fields: [
          {
            name: '__sequence',
            title: '#',
            titleClass: 'text-right',
            dataClass: 'text-right'
          },
          {
            name: '__checkbox',
            titleClass: 'text-center',
            dataClass: 'text-center',
          },
          {
            name: 'name',
            sortField: 'name',
          },
          {
            name: 'forge_id',
            sortField: 'forge_id'
          },
          {
            name: 'state',
            sortField: 'state'
          }
        ],
        message:'',
        httpOptions: {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN']
          }
        }
    }
    },
    computed: {
      apiUrl() {
        return '/api/v1/users/' + this.user.id + '/servers'
      }
    },
    methods: {
      customUsersLabel({ name, email , id}) {
        return `${name} - ${email} - ${id}`
      },
      fetchServers() {
        let url = '/api/v1/users/' + this.user.id + '/servers'
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
          this.fetchServers()
        }).catch((error) => {
          console.log(error)
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