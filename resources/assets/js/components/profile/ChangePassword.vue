<template>
  <form @submit.prevent="update" @keydown="form.onKeydown($event)">
    <div class="form-row">
      <!-- Password -->
      <div class="col-md-6 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
          <label for="password">Новый пароль  <b class="text-danger">*</b></label>
          <input v-model="form.password" type="password" name="password" class="form-control">
          <has-error :form="form" field="password"></has-error>
        </div>
      </div>
        <!-- Password Confirmation -->
      <div class="col-md-6 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('password_confirmation') }">
          <label for="password_confirmation">Подтвердите пароль  <b class="text-danger">*</b></label>
          <input v-model="form.password_confirmation" type="password" name="password_confirmation" class="form-control"
            :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
          <has-error :form="form" field="password_confirmation"></has-error>
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <v-button class="btn-sm text-uppercase" type="primary" :loading="form.busy">Обновить</v-button>
  </form>
</template>

<script>
import Form from "vform";

export default {
  
  scrollToTop: false,

  data: () => ({
    form: new Form({
      password: "",
      password_confirmation: ""
    })
  }),

  methods: {
    async update() {
      await this.form.patch("/api/change-password");

      this.form.reset();

      IziToast.success({ message: this.$t("password_updated") });
    }
  }
};
</script>