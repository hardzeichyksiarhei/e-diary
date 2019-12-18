<template>
    <div class="messages-page">
			<div class="row">
        <div class="col-md-3 mailbox-nav sticky">
					<router-link class="btn btn-primary btn-block margin-bottom" :to="{ name: 'messages.compose' }">
						Написать
					</router-link>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Папки</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
								<router-link tag="li" :to="{ name: 'messages.inbox' }" active-class="active">
									<a><i class="fa fa-inbox"></i>Входящие<span v-if="totalNotifications" class="label label-primary pull-right">{{ totalNotifications }}</span></a>
								</router-link>
								<router-link tag="li" :to="{ name: 'messages.starred' }" active-class="active">
									<a><i class="fa fa-star"></i>Помеченные</a>
								</router-link>
								<router-link tag="li" :to="{ name: 'messages.sent' }" active-class="active">
									<a><i class="fa fa-envelope"></i>Отправленные</a>
								</router-link>
								<router-link tag="li" :to="{ name: 'messages.trash' }" active-class="active">
									<a><i class="fa fa-trash"></i>Корзина</a>
								</router-link>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <transition name="fade" mode="out-in">
            <router-view/>
        	</transition>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
	middleware: ['auth'],

	name: "index",

	computed: mapGetters({
		'totalNotifications': 'messages/totalNotifications'
	})
}
</script>

<style lang="less" scoped>
	.nav-pills > li.active > a:focus {
			color: inherit;
			background-color: transparent;
	}
</style>