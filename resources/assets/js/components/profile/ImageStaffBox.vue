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

            <modal :modal-id="'remove-user'">
              <template v-slot:title>Удаление аккаунта</template>
              <template
                v-slot:body
              >Вы действительно хотите удалить свой аккаунт? Все данные будут утеряны.</template>
              <template v-slot:footer>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button
                  type="button"
                  class="btn btn-primary"
                  data-dismiss="modal"
                  @click="userRemove(user.id)"
                >Удалить</button>
              </template>
            </modal>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</template>

<script>
    import axios from 'axios'
    import { mapGetters } from 'vuex'

    import Modal from '~/components/Modal'

    export default {
        name: 'image-student-box',

        components: {
            Modal
        },

        computed: mapGetters({
            check: 'auth/check',
            auth_user: 'auth/user'
        }),

        props: {
            user: {
                type: Object,
                default: () => {}
            }
        },

        filters: {
            isEmpty (value) {
                return value || 'Нет данных'
            }
        },

        methods: {
            async userRemove() {
                try {
                  await axios.delete('/api/user', {
                      params: { ids: this.user.id }
                  })

                   if (this.auth_user.id === this.user.id) {
                      // Log out the user.
                      this.$store.commit("auth/LOGOUT");

                      // Redirect to login.
                      this.$router.push({ name: "login" });
                   } else {
                     this.$router.go(-1);
                   }
                } catch (error) {
                    IziToast.error({ message: error.response.data.message })
                }
            }
        }

    }
</script>
</script>

<style lang="less" scoped></style>


