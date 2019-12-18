<template>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Обо мне</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-user-secret margin-r-5"></i> Должность</strong>

            <p class="text-muted">{{ user.profile.position | isEmpty }}</p>

            <hr>

            <strong><i class="fa fa-university margin-r-5"></i> Звание</strong>

            <p class="text-muted">{{ user.profile.rank | isEmpty }}</p>

            <hr>

            <strong><i class="fa fa-mortar-board margin-r-5"></i> Степень</strong>

            <p class="text-muted">{{ user.profile.degree | isEmpty }}</p>

            <hr>

            <strong><i class="fa fa-pencil margin-r-5"></i> Описание</strong>

            <p>{{ user.profile.description | isEmpty }}</p>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {

        name: 'about-me-staff-box',

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


