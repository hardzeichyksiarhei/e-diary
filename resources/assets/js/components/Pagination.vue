<template>
    <ul class="custom-pagination" v-if="pagination.data.length">
      <li :class="{ 'disabled' : !pagination.prev_page_url }">
        <a href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="prevPage()">
          <i class="material-icons" aria-hidden="true">keyboard_arrow_left</i>
        </a>
      </li>
      <li :class="{ 'disabled' : !pagination.next_page_url }">
        <a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="nextPage()">
          <i class="material-icons" aria-hidden="true">keyboard_arrow_right</i>
        </a>
      </li>
    </ul>
</template>
<script>
  export default{
    props: {
      pagination: {
        type: Object,
        required: true
      }
    },
    methods: {
      prevPage () {
        if (!this.pagination.prev_page_url) return

        this.pagination.current_page--
        this.$emit('paginate')
      },
      nextPage () {
        if (!this.pagination.next_page_url) return

        this.pagination.current_page++
        this.$emit('paginate')
      }
    }
  }
</script>

<style lang="less" scoped>
  .custom-pagination {
    padding: 0;
    margin: 0;
    list-style-type: none;
    li {
      display: inline-block;
      &.disabled a {
        opacity: .3;
        cursor: not-allowed;
      }
    }
    a {
      display: block;
      line-height: 0;
      padding: 10px 0;
    }
  }
</style>
