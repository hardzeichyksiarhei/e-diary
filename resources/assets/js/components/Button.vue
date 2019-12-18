<template>
  <button :type="nativeType" :disabled="loading" class="btn text-white" :class="{
    [`btn-${type}`]: true,
    'btn-block': block,
    'btn-lg': large,
    'btn-loading': loading
  }" @click="$emit('click')">
    <slot/>
  </button>
</template>

<script>
export default {
  name: 'VButton',

  props: {
    type: {
      type: String,
      default: 'primary'
    },

    nativeType: {
      type: String,
      default: 'submit'
    },

    loading: {
      type: Boolean,
      default: false
    },

    block: Boolean,
    large: Boolean
  }
}
</script>
