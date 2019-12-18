<template>
    <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" :src="user.photo_url" alt="User profile picture">

            <h3 class="profile-username text-center">{{ user.name }}</h3>

            <p class="text-muted text-center">Студент</p>

            <ul class="list-group list-group-unbordered mb-0">
                <li class="list-group-item border-top-0">
                    <b>E-mail:&nbsp;</b> <a :href="`mailto:${user.email}`">{{ user.email }}</a>
                </li>
                <li class="list-group-item">
                    <b>Факультет:&nbsp;</b> {{ user.profile.faculty | isEmpty }}
                </li>
                <li class="list-group-item">
                    <b>Курс:&nbsp;</b> {{ user.profile.course | isEmpty }}
                </li>
                <li class="list-group-item border-bottom-0">
                    <b>Группа:&nbsp;</b> {{ user.profile.group | isEmpty }}
                </li>
            </ul>

            <!-- <a href="#" class="btn btn-primary btn-block text-uppercase">Статистика</a> -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {

        name: 'image-student-box',

        computed: mapGetters({
            check: 'auth/check',
            user: 'auth/user'
        }),

        filters: {
            isEmpty (value) {
                return value || 'Нет данных'
            }
        }

    }
</script>

<style lang="less" scoped></style>


