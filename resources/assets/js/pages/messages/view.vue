<template>
	<div class="view-page">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Сообщение</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<div class="mailbox-read-info">
					<h3>{{ msg.message.subject }}</h3>
					<h5>Кому: {{ msg.message.sender.name }}
						<span class="mailbox-read-time pull-right">{{ msg.created_at }}</span></h5>
				</div>
				<!-- /.mailbox-read-info -->
				<div class="mailbox-controls with-border text-center no-padding-rl">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-flat btn-sm btn-mi d-flex align-items-center">
							<i class="material-icons text-danger">delete</i>&nbsp;В корзину
						</button>
						<button type="button" class="btn btn-default btn-flat btn-sm btn-mi d-flex align-items-center">
							<i class="material-icons text-primary">print</i>&nbsp;Печать
						</button>
					</div>
					<!-- /.btn-group -->
				</div>
				<!-- /.mailbox-controls -->
				<div class="mailbox-read-message" v-html="msg.message.message"></div>
				<!-- /.mailbox-read-msg -->
			</div>
			<!-- /.box-body -->
		</div>
	</div>
</template>

<script>
import axios from 'axios'

export default {
	data () {
		return {
			msg: {}
		}
	},

	created () {
		this.fetchMessage()
	},

	methods: {
		async fetchMessage () {
			const { data } = await axios.get(`/api/messages/${this.$route.params.id}`)
			this.msg = data
			console.log(data)
		}
	}
}
</script>

<style lang="less" scoped>
	.mailbox-read-msg {
		font-size: 14px;
	}
</style>