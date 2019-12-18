<template>
  <div class="row">
    <div class="col-12">
      <transition name="fade" mode="out-in">
        <router-view/>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('change_password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>

<style lang="scss">
  .settings-card {
    position: sticky;
    top: 1.5rem;
  }
  .settings-card .card-body {
    padding: 0;
  }
</style>
