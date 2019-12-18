<template>
    <div class="admin-page">
        <transition name="fade" mode="out-in">
            <router-view/>
        </transition>
    </div>
</template>

<script>
  export default {
    middleware: ['auth', 'admin'],

    name: "index",

    computed: {}
  }
</script>

<style lang="scss">
</style>