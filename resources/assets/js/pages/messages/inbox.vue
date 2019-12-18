<template>
	<div class="inbox-page">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Входящие</h3>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<div class="mailbox-meta with-border sticky">
					<div class="mailbox-controls">
						<div class="d-flex align-items-center">
							<!-- Check all -->
							<checkbox v-model="selectAll"/>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-flat btn-sm btn-mi d-flex align-items-center" @click.prevent="inTrash">
									<i class="material-icons text-danger">delete</i><span class="hidden-xs">&nbsp;В корзину</span>
								</button>
								<button type="button" class="btn btn-default btn-flat btn-sm btn-mi d-flex align-items-center" @click.prevent="refresh(1, inbox.to)">
									<i class="material-icons text-primary">refresh</i><span class="hidden-xs">&nbsp;Обновить</span>
								</button>
							</div>
						</div>
						<div class="has-feedback">
							<input type="text" class="form-control input-sm" placeholder="Поиск" v-model="search">
							<i class="material-icons form-control-feedback">search</i>
						</div>
					</div>
					<div v-if="selectMessageID.length > 1" class="mailbox-selected-tools">
						<span>{{ selectedCount }}</span>
						<a href="#" @click.prevent="unselectAll">Снять выделение</a>
					</div>
				</div>
				<div class="mailbox-messages">
					<div class="table-responsive">
						<table class="table">
							<colgroup>
								<col width="40">
								<col width="24">
								<col width="160">
								<col class="mailbox-excerpt">
								<col width="100">
							</colgroup>
							<tbody>
								<template v-if="!inboxEmpty">
									<tr :class="{ 'mailbox-unread' : !msg.is_read }" v-for="msg in messages" :key="msg.id">
										<td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" :id="`message-${msg.id}`" class="custom-control-input" 
													:value="msg.id"
													v-model="selectMessageID">
												<label :for="`message-${msg.id}`" class="custom-control-label"></label>
											</div>
										</td>
										<td class="mailbox-star no-padding-rl text-center">
											<a href="#" @click.prevent="toggleStarred($event, msg.id)"><i class="fa text-yellow" :class="{ 'active' : msg.is_starred }"></i></a>
										</td>
										<td @click.prevent="view(msg.id)" class="mailbox-name" nowrap>
											<div style="white-space: nowrap; overflow: hidden;">
												{{ msg.message.sender.name }}
											</div>
										</td>
										<td @click.prevent="view(msg.id)" class="mailbox-subject">
											<div style="white-space: nowrap; overflow: hidden;">
												<span :class="{ 'text-bold' : !msg.is_read }">{{ msg.message.subject }}</span> - {{ msg.message.excerpt }}
											</div>
										</td>
										<td @click.prevent="view(msg.id)" class="mailbox-date" nowrap>{{ msg.created_at }}</td>
									</tr>
								</template>
                <tr v-else>
                  <td colspan="5" align="center" bgcolor="#fff">
                    <span v-if="inboxEmpty">Сообщений нет</span>
                  </td>
                </tr>
							</tbody>
						</table>
						<!-- /.table -->
					</div>
					<!-- /.table-responsive -->
					<div class="mailbox-add" v-if="inbox.current_page < inbox.last_page">
						<a class="btn btn-link btn-sm btn-mi" v-on:click.prevent="fetchInbox(inbox.current_page + 1)">
							<i style="font-size: 30px;" class="material-icons">add</i>
						</a>
					</div>
					<!-- /.mailbox-add -->
				</div>
				<!-- /.mail-box-messages -->
			</div>
			<!-- /.box-body -->
		</div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
	name: 'inbox',

	data () {
		return {
			selectAll: false,
			selectMessageID: [],
			messages: [],
			inbox: {
				data: [],
				total: 0,
				per_page: 2,
				from: 1,
				to: 0,
				current_page: 1
			},
      inboxEmpty: false,
      search: ''
		}
	},

	metaInfo() {
		return { title: `Входящие (${this.totalNotifications})` }
	},

	computed: {
		selectedCount () {
			if (this.selectMessageID.length < 5) return `Выбрано ${this.selectMessageID.length} письма`
			else return `Выбрано ${this.selectMessageID.length} писем`
		},
		...mapGetters({
			'user': 'auth/user',
			'totalNotifications': 'messages/totalNotifications'
		})
	},

	watch: {
		selectAll (value) {
			if (value) this.selectMessageID = _.map(this.messages, 'id')
			if (!value && this.selectMessageID.length === this.messages.length) this.selectMessageID = []
		},
		selectMessageID (newValue, oldValue) {
			if (newValue.length > 0 && newValue.length < this.messages.length ) this.selectAll = false
			if (newValue.length && newValue.length === this.messages.length) this.selectAll = true
		}
	},

	created () {
		this.fetchInbox()
	},

	methods: {
		async fetchInbox (page = 1, per_page = 20) {
      this.$store.dispatch("loading/changeLoading");
			try {
				const { data } = await axios.get(`/api/messages/inbox/?page=${page}&per_page=${per_page}`, {
          params: { search: this.search }
        })
				this.inbox = data
				this.messages.push(...this.inbox.data)
				if (this.selectAll) {
					let ids = _.map(this.inbox.data, 'id')
					this.selectMessageID.push(...ids)
				}
				if (!this.inbox.data.length) this.inboxEmpty = true
			} catch (error) {
				console.error(error)
			} finally {
        this.$store.dispatch("loading/changeLoading");
      }
		},
		async toggleStarred (event, id) {
			let star = event.currentTarget.children[0];
			star.classList.toggle('active')
			try {
				await axios.patch(`/api/messages/starred/${id}`)
			} catch (error) {
				console.error(error)
			}
		},
		async inTrash () {
			let ids = this.selectMessageID
			if (!ids.length) {
				IziToast.warning({ message: 'Ничего не отмечено' });
				return
			}
			try {
				await axios.patch('/api/messages/trash/in', { ids })
				this.refresh(1, this.inbox.to)
				IziToast.info({ message: `${ids.length} сообщений перемещены в корзину` });
			} catch (error) {
				console.error(error)
			}
		},
		async refresh (page = 1, per_page = 20) {
			per_page = per_page || 20
			try {
				this.unselectAll()
				const { data } = await axios.get(`/api/messages/inbox/?page=${page}&per_page=${per_page}`)
				this.messages = data.data
			} catch (error) {
				console.error(error)
			}
		},
		view (id) {
			this.$router.push({ 
				name: 'messages.view', 
				params: { id }
			})
		},
		unselectAll () {
			this.selectAll = false
			this.selectMessageID = []
		}
	}
}
</script>

<style lang="less" scoped></style>