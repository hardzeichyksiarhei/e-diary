<template>
  <div class="card">
    <div v-if="title" class="card-header" :class="headerClass">
      {{ title }}
    </div>

    <div class="card-body">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',
  props: ['title', 'header-class']
}
</script>