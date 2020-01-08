<template>
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="loading" v-if="loading">
          <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
        </div>
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->
						<!-- <messages-notifications v-if="notifications.length"/> -->
            
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img :src="user.photo_url" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">{{ full_name }}</span>
              </a>
              <ul class="dropdown-menu animated-dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img :src="user.photo_url" class="img-circle" alt="User Image">

                  <p>
                    {{ full_name_short }} - {{ user.role | transRole }}
                    <small>Зарегистрирован {{ user.created_at }}</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <!-- <li class="user-body">
                  <div class="row">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </div>
                </li> -->
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <router-link :to="{ name: 'profile' }" class="btn btn-default btn-flat">Профайл</router-link>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#logout">Выйти</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
      </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import MessagesNotifications from './MessagesNotifications'

export default {
  data: () => ({
    appName: window.config.appName
  }),

  components: {
    MessagesNotifications
  },

  computed:{
    ...mapGetters({
      user: 'auth/user',
      check: 'auth/check',
      // notifications: 'messages/notifications',
      loading: 'loading/loading'
    }),
    full_name() {
      let { first_name, last_name, patronymic_name } = this.user;
      let res = last_name + ' ' + first_name;
      if (patronymic_name.length) res += ' ' + patronymic_name;
      return res;
    },
    full_name_short() {
      let { first_name, last_name, patronymic_name } = this.user;
      let res = last_name + ' ' + first_name;
      if (patronymic_name.length) {
        res = last_name + ' ' + first_name[0] + '. ' + patronymic_name[0] + '.';
      }
      return res;
    }
},

  filters: {
    transRole (value) {
      if (value === 'teacher') return 'Преподаватель'
      if (value === 'student') return 'Студент'
      if (value === 'admin') return 'Админ.'
    }
  },

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style lang="scss" scoped>

.loading {
  position: absolute;
  color: #fff;
  left: calc(50% - 18px);
  top: 10px;
}

</style>
