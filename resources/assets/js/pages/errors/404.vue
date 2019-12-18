<template>
  <card class="text-center">
    <h3 class="mb-4">Страница не найдена</h3>

    <div class="links">
      <router-link :to="{ name: 'dashboard' }">
        Панель управления
      </router-link>
    </div>
  </card>
</template>

<script>
export default {
  name: 'not-found'
}
</script>
