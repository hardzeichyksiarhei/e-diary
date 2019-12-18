<template>
	<div class="sent-page">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Отправленные</h3>
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
								<button type="button" class="btn btn-default btn-flat btn-sm btn-mi d-flex align-items-center" @click.prevent="refresh(1, sent.to)">
									<i class="material-icons text-primary">refresh</i><span class="hidden-xs">&nbsp;Обновить</span>
								</button>
							</div>
            </div>
            <div class="has-feedback">
							<input type="text" class="form-control input-sm" placeholder="Поиск">
							<i class="material-icons form-control-feedback">search</i>
						</div>
          </div>
          <div v-if="selectMessageID.length > 1" class="mailbox-selected-tools">
						<span>{{ selectedCount }}</span>
						<a href="#">Выбрать все письма в этой папке</a>
						<a href="#" @click.prevent="unselectAll">Снять выделение</a>
					</div>
        </div>
				<div class="table-responsive mailbox-messages">
					<table class="table table-hover table-striped">
						<colgroup>
							<col width="40">
							<col width="24">
							<col width="200">
							<col>
							<col width="120">
						</colgroup>
						<tbody>
							<template v-if="!sentLoading && !sentEmpty">
								<tr v-for="msg in messages" :key="msg.id">
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
											Кому:&nbsp;{{ msg.receiver_name }}
										</div>
									</td>
									<td @click.prevent="view(msg.id)" class="mailbox-subject">
										<div style="white-space: nowrap; overflow: hidden;">
											<span>{{ msg.subject }}</span> - {{ msg.excerpt }}
										</div>
									</td>
									<td @click.prevent="view(msg.id)" class="mailbox-date" nowrap>{{ msg.created_at }}</td>
								</tr>
							</template>
							<tr v-else>
								<td colspan="5" align="center" bgcolor="#fff">
									<span v-if="sentLoading">Загрузка сообщений...</span>
									<span v-else-if="sentEmpty">Сообщений нет</span>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- /.table -->
				</div>
        <div class="mailbox-add" v-if="sent.current_page < sent.last_page">
          <a class="btn btn-link btn-sm btn-mi" v-on:click.prevent="fetchSent(sent.current_page + 1)">
            <i style="font-size: 30px;" class="material-icons">add</i>
          </a>
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
	name: 'sent-page',

	data () {
		return {
			selectAll: false,
      selectMessageID: [],
      messages: [],
			sent: {
				data: [],
				total: 0,
				per_page: 2,
				from: 1,
				to: 0,
				current_page: 1
			},
			sentLoading: true,
			sentEmpty: false
		}
	},

	metaInfo() {
		return { title: 'Отправленные' }
	},

	computed: {
    selectedCount () {
			if (this.selectMessageID.length < 5) return `Выбрано ${this.selectMessageID.length} письма`
			else return `Выбрано ${this.selectMessageID.length} писем`
		},
    ...mapGetters({
      'user': 'auth/user'
    })
  },

	created () {
		this.fetchSent()
	},

	methods: {
		async fetchSent (page = 1, per_page = 20) {
			try {
				const { data } = await axios.get(`/api/messages/sent/?page=${page}&per_page=${per_page}`)
        this.sent = data
				this.messages.push(...this.sent.data)
				if (this.selectAll) {
					let ids = _.map(this.sent.data, 'id')
					this.selectMessageID.push(...ids)
				}
        this.sentLoading = false
				if (!this.sent.data.length) this.sentEmpty = true
        console.log(data)
			} catch (error) {
				console.log(error)
			}
		},
		async toggleStarred (event, id) {
			let star = event.currentTarget.childNodes[0];
			star.classList.toggle('active')
			try {
				const data = await axios.patch(`/api/messages/starred/${id}`)
				console.log(data)
			} catch (error) {
				console.log(error)
			}
		},
		async inTrash () {
			try {
				let ids = this.selectMessageID
				await axios.patch('/api/messages/trash/in', { ids })

				if (ids.length === this.sent.data.length && this.sent.current_page !== 1) {
					this.sent.current_page--;
				}
				this.fetchSent()
				if (!this.sent.data.length) this.sentEmpty = true
			} catch (error) {
				console.log(error)
			}
		},
		view (id) {
			this.$router.push({ 
				name: 'messages.view', 
				params: { id }
			})
		}
	}
}
</script>

<style lang="less" scoped></style>