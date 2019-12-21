<template>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Доп. информация</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <strong><i class="fa fa-university margin-r-5"></i> Преподаватель</strong>

            <p class="text-muted">{{ user.profile.teacher | isEmpty }}</p>

            <hr>

            <strong><i class="fa fa-mortar-board margin-r-5"></i> Медицинская группа здоровья</strong>

            <p class="text-muted">{{ user.profile.health_group | isEmpty }}</p>

            <hr>

            <strong><i class="fa fa-pencil margin-r-5"></i> Заболевание</strong>

            <p>{{ user.profile.disease | isEmpty }}</p>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</template>

<script>
    export default {

        name: 'about-me-student-box',

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
        }

    }     
</script>

<style lang="less" scoped></style>


