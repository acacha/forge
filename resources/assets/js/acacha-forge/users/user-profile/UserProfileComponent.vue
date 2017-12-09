<template>
    <div>
        <div class="row">
            <div class="col-md-3">
                <user-profile-info-box></user-profile-info-box>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#user" data-toggle="tab" aria-expanded="false">User</a></li>
                        <li><a href="#personal" data-toggle="tab" aria-expanded="false">Personal</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="user">
                            <user-form></user-form>
                        </div>
                        <div class="tab-pane" id="personal">
                            TODO
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <adminlte-flash-message></adminlte-flash-message>

    </div>
</template>

<script>

  import {UserProfileInfoBox , UserProfileStoreComponent, UserForm } from 'acacha-users'

  import {AdminlteFlashMessage} from 'adminlte-vue'

  export default {
    extends: UserProfileStoreComponent,
    name: 'UserProfile',
    components: {UserProfileInfoBox, UserForm, AdminlteFlashMessage},
    created () {
      console.log(AdminlteFlashMessage)
      this.$store.dispatch('acacha-users/getUser', true)
    }
  }

</script>