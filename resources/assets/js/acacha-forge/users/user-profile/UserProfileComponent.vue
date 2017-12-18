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
                            <logged-user-name-form></logged-user-name-form>
                            <br>
                            <logged-user-email-form></logged-user-email-form>
                            <br>
                            <logged-user-password-form></logged-user-password-form>
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
  import { UserProfileInfoBox, UserProfileStoreComponent, LoggedUserNameForm, LoggedUserEmailForm, LoggedUserPasswordForm } from 'acacha-users'
  import { AdminlteFlashMessageComponent } from 'adminlte-vue'
  import { mapGetters } from 'vuex'

  export default {
    extends: UserProfileStoreComponent,
    name: 'UserProfile',
    components: {UserProfileInfoBox, LoggedUserNameForm, LoggedUserEmailForm, LoggedUserPasswordForm, AdminlteFlashMessageComponent},
    computed: {
      ...mapGetters({
        user: 'acacha-users/user'
      })
    },
    created () {
      this.$store.dispatch('acacha-users/getUser', true)
    }
  }
</script>