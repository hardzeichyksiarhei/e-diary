<template>
	<li class="dropdown messages-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-envelope-o"></i>
			<span v-if="totalNotifications" class="label label-success">{{ totalNotifications }}</span>
		</a>
		<div class="dropdown-menu messages-dropdown animated-dropdown-menu">
			<header class="messages-dropdown__header">
				{{ notifications.length }} последних непрочитанных сообщений
			</header>
			<ul class="messages-dropdown__body messagesList">
				<!-- start message -->
				<li class="messagesItem" v-for="notification in notifications" :key="notification.id">
					<router-link class="clearfix" :to="{ name: 'messages.view', params: { id: notification.id } }">
						<img :src="notification.message.sender_avatar" class="messagesItem__img pull-left img-circle" alt="User Image">
						<div class="messagesItem__content">
							<div class="d-flex justify-content-between align-items-center">
								<strong>{{ notification.message.sender_name }}</strong>
								<small>{{ notification.created_at }}</small>
							</div>
							<p class="messagesItem__subject">{{ notification.message.subject }}</p>
						</div>
					</router-link>
				</li>
				<!-- end message -->
			</ul>
			<footer class="messages-dropdown__footer">
				<router-link :to="{ name: 'messages.inbox' }">Просмотреть все сообщения</router-link>
			</footer>
		</div>
	</li>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: mapGetters({
    notifications: 'messages/notifications',
    totalNotifications: 'messages/totalNotifications'
  })
}
</script>

<style lang="less" scoped>
	.navbar-nav > .messages-menu > .dropdown-menu.messages-dropdown {
		width: 320px;
	}
	.messages-dropdown {
		&__header {
			padding: 7px 10px;
			border-bottom: 1px solid #eee;
			color: #444444;
		}
		&__footer {
			border-top: 1px solid #eee;
			padding: 7px 10px;
			text-align: center;
			a {
				font-size: 12px;
				color: #444;
			}
		}
	}
	.messagesList {
		max-height: 300px;
    margin: 0;
    padding: 0;
    list-style: none;
    overflow-x: hidden;
	}
	.messagesItem {
		padding: 15px;
		border-bottom: 1px solid #f4f4f4;
		&:last-of-type {
			border-bottom: none;
		}
		&__content {
			color: #444;
		}
		&__img {
			width: 50px;
			margin-right: 15px;
		}
		&__subject {
			margin: 5px 0 0 0;
		}
	}
</style>
