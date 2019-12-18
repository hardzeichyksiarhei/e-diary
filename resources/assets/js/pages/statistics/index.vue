<template>
  <div class="row">
    <div class="col-md-12">
      <transition name="fade" mode="out-in">
        <router-view/>
      </transition>
    </div>
  </div>
</template>

<script>
  export default {
    middleware: ['auth', 'student'],

    name: 'index'
  }
</script>

<style lang="scss" scoped>
</style>
