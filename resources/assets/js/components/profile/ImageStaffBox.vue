<template>
    <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" :src="user.photo_url" alt="User profile picture">

            <h3 class="profile-username text-center">{{ user.name }}</h3>

            <p class="text-muted text-center">{{ user.role === 'teacher' ? 'Преподаватель' : 'Администратор' }}</p>

            <ul class="list-group list-group-unbordered mb-0">
                <li class="list-group-item border-top-0">
                    <b>E-mail:&nbsp;</b> <a :href="`mailto:${user.email}`">{{ user.email }}</a>
                </li>
                <li class="list-group-item border-bottom-0">
                    <b>Моб. телефон:&nbsp;</b> 
										<a v-if="user.profile.phone" href="tel:+375447610533">{{ user.profile.phone }}</a>
										<template v-else>Нет данных</template>
                </li>
            </ul>

            <button class="btn btn-flat btn-danger w-100 mt-2" data-toggle="modal" data-target="#remove-user">
              <i class="fa fa-fw fa-trash"></i>&nbsp;Удалить
            </button>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</template>

<script>
  import { mapGetters } from 'vuex';

  export default {

    name: 'image-staff-box',

    computed: mapGetters({
      check: 'auth/check',
      user: 'auth/user'
    })

  }
</script>

<style lang="less" scoped></style>


