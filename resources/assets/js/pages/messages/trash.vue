<template>
	<div class="trash-page">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Входящие</h3>

				<div class="box-tools pull-right">
					<div class="has-feedback">
						<input type="text" class="form-control input-sm" placeholder="Поиск по имени...">
						<i class="material-icons form-control-feedback">search</i>
					</div>
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<div class="mailbox-controls">
					<div class="d-flex align-items-center">
						<!-- Check all -->
						<checkbox v-model="selectAll"/>
						<div class="btn-group ml-3">
							<button type="button" class="btn btn-default btn-flat btn-sm btn-mi d-flex align-items-center" @click.prevent="deleteForever">
								<i class="material-icons">delete_forever</i>&nbsp;УДАЛИТЬ НАВСЕГДА
							</button>
							<button type="button" class="btn btn-default btn-flat btn-sm btn-mi d-flex align-items-center" @click.prevent="reestablish">
								<i class="material-icons">keyboard_return</i>&nbsp;ВОССТАНОВИТЬ
							</button>
							<button type="button" class="btn btn-default btn-flat btn-sm btn-mi"><i class="material-icons">refresh</i></button>
						</div>
					</div>
					<div class="mailbox-pagination">
						<mail-box-pagination  
							:pagination="trash"
							@paginate="fetchTrash()"
						/>
					</div>
				</div>
				<div class="table-responsive mailbox-messages">
					<table class="table table-hover table-striped">
						<colgroup>
							<col width="40">
							<col width="200">
							<col>
							<col width="120">
						</colgroup>
						<tbody>
							<template v-if="!trashLoading && !trashEmpty">
								<tr v-for="msg in trash.data" :key="msg.id">
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" :id="`message-${msg.id}`" class="custom-control-input" 
												:value="msg.id"
												v-model="selectMessageID">
											<label :for="`message-${msg.id}`" class="custom-control-label"></label>
										</div>
									</td>
									<td @click.prevent="view(msg.id)" class="mailbox-name" nowrap>
										<div style="white-space: nowrap; overflow: hidden;">
											<router-link :to="{ name: 'messages.view', params: { id: msg.id }}">
												{{ msg.folder === 'sent' ? `Кому: ${msg.user.name}` : `От: ${msg.message.sender.name}` }}
											</router-link>
										</div>
									</td>
									<td @click.prevent="view(msg.id)" class="mailbox-subject">
										<div style="white-space: nowrap; overflow: hidden;">
											<span>{{ msg.message.subject }}</span> - {{ msg.message.excerpt }}
										</div>
									</td>
									<td @click.prevent="view(msg.id)" class="mailbox-date" nowrap>{{ msg.created_at }}</td>
								</tr>
							</template>
							<tr v-else>
								<td colspan="5" align="center" bgcolor="#fff">
									<span v-if="!trashEmpty">Загрузка сообщений...</span>
									<span v-else>Сообщений нет</span>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- /.table -->
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
import MailBoxPagination from '~/components/MailBoxPagination'

export default {
	name: 'trash-page',

	components: {
		MailBoxPagination
	},

	data () {
		return {
			selectAll: false,
			selectMessageID: [],
			trash: {
				data: [],
				total: 0,
				per_page: 2,
				from: 1,
				to: 0,
				current_page: 1
			},
			trashLoading: true,
			trashEmpty: false
		}
	},

	computed: mapGetters({
		'user': 'auth/user'
	}),

	created () {
		this.fetchTrash()
	},

	methods: {
		async fetchTrash () {
			try {
				const { data } = await axios.get(`/api/messages/trash/?page=${this.trash.current_page}`)
				this.trash = data
				this.trashLoading = false
				if (!this.trash.data.length) this.trashEmpty = true
			} catch (error) {
				console.log(error)
			}
		},
		async deleteForever () {
			try {
				let ids = this.selectMessageID
				await axios.delete('/api/messages', { params: { ids } })
				if (ids.length === this.trash.data.length && this.trash.current_page !== 1) {
					this.trash.current_page--;
				}
				this.fetchTrash()
			} catch (error) {
				console.log(error)
			}
		},
		async reestablish () {
			try {
				let ids = this.selectMessageID
				await axios.patch('/api/messages/trash/out', { ids })
				if (ids.length === this.trash.data.length && this.trash.current_page !== 1) {
					this.trash.current_page--;
				}
				this.fetchTrash()
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