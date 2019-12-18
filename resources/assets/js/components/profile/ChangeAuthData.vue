<template>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
        <!-- Name -->
        <div class="form-row">
            <div class="col-md-6 col-xs-12">
                <div class="form-group" :class="{ 'has-error': form.errors.has('first_name') }">
                    <label for="first_name">Имя <b class="text-danger">*</b></label>
                    <input class="form-control" id="first_name" type="text" name="first_name" placeholder="Enter first name"
                        v-model="form.first_name"
                    >
                    <has-error :form="form" field="first_name"></has-error>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group" :class="{ 'has-error': form.errors.has('last_name') }">
                    <label for="last_name">Фамилия <b class="text-danger">*</b></label>
                    <input class="form-control" id="last_name" type="text" name="last_name" placeholder="Enter last name"
                        v-model="form.last_name"
                    >
                    <has-error :form="form" field="last_name"></has-error>
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
            <label for="email">Email <b class="text-danger">*</b></label>
            <input class="form-control" id="email" type="email" placeholder="Enter email"
                v-model="form.email"
            >
            <has-error :form="form" field="email"></has-error>
        </div>

        <!-- Submit Button -->
        <v-button class="btn-sm text-uppercase" type="primary" :loading="form.busy">Обновить</v-button>
    </form>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        name: 'change-auth-data',

        scrollToTop: false,

        data: () => ({
            form: new Form({
                first_name: '',
                last_name: '',
                email: ''
            })
        }),

        computed: mapGetters({
            user: 'auth/user'
        }),

        created() {
            // Fill the form with user data.
            this.form.keys().forEach(key => {
                this.form[key] = this.user[key]
            })
        },

        methods: {
            async update() {
                const { data } = await this.form.patch('/api/change-auth-data')

                await this.$store.dispatch('auth/updateUser', data)

                IziToast.success({ message: 'Ваша информация обновлена' })
            }
        }
    }
</script>
