<template>
<div v-if="pagination.total !== 0" class="mailbox-pagination">
	<span>{{ pagination.from }} - {{ pagination.to }} из {{ pagination.total }}</span>
	<div class="btn-group ml-2">
		<button type="button" class="btn btn-default btn-flat btn-sm btn-mi"
			:disabled="pagination.current_page <= 1"
			@click.prevent="changePage(pagination.current_page - 1)"
		>
			<i class="material-icons">keyboard_arrow_left</i>
		</button>
		<button type="button" class="btn btn-default btn-flat btn-sm btn-mi"
			:disabled="pagination.current_page >= pagination.last_page"
			v-on:click.prevent="changePage(pagination.current_page + 1)"
		>
			<i class="material-icons">keyboard_arrow_right</i>
		</button>
	</div>
</div>
	<!-- <ul class="pagination">
		<li v-if="pagination.current_page > 1">
			<a href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1)">
				<span aria-hidden="true">«</span>
			</a>
		</li>
		<li v-if="pagination.current_page < pagination.last_page">
			<a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">
				<span aria-hidden="true">»</span>
			</a>
		</li>
	</ul> -->
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
    changePage (page) {
      this.pagination.current_page = page
      this.$emit('paginate')
    }
  }
}
</script>
