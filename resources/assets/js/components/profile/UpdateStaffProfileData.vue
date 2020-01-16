<template>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)">
        <div class="form-row">
            <div class="col-md-2 col-xs-12">
              <div class="form-group" :class="{ 'has-error': form.errors.has('birthday') }">
                <label for="birthday">День рождения <b class="text-danger">*</b></label>
                <input type="text" class="form-control" id="birthday" name="birthday" placeholder="дд/мм/гггг"
									v-model="form.birthday"
                >
                <small class="form-text text-muted">Полных лет</small>
                <has-error :form="form" field="birthday"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12">
              <div class="form-group">
                <label for="position">Должность</label>
                <input type="text" class="form-control" id="position" name="position"
                        v-model="form.position"
                >
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="rank">Звание</label>
                <input type="text" class="form-control" id="rank" name="rank"
                        v-model="form.rank"
                >
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="degree">Степень</label>
                <input type="text" class="form-control" id="degree" name="degree"
                        v-model="form.degree"
                >
              </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-xs-12">
              <div class="form-group">
                <label for="description">Описание</label>
                <textarea rows="6" class="form-control v-resize" id="description" name="description"
                        v-model="form.description"
                ></textarea>
              </div>
            </div>
        </div>
        <v-button class="btn-sm text-uppercase" type="primary" :loading="form.busy">Обновить</v-button>
    </form>
</template>

<script>
import Form from "vform";
import axios from "axios";
import { mapGetters } from "vuex";
import InputmaskDate from 'inputmask/dist/inputmask/inputmask.date.extensions';

export default {
  name: "update-staff-profile-data",
  data: () => ({
    form: new Form({
      birthday: '',
      position: '',
      rank: '',
      degree: '',
      description: null
    })
  }),
  computed: {
    ...mapGetters({
      user: "auth/user"
    })
	},
	mounted () {
		let ageSelector = document.getElementById('birthday');
		InputmaskDate({
			alias: 'dd/mm/yyyy',
			placeholder: 'дд/мм/гггг'
		}).mask(ageSelector);
	},
  created() {
    (async () => {
      try {
        // Fill the form with profileStaff data.
        const { data } = await axios.get('/api/profile/staff')
        if (data) {
          this.form.keys().forEach(key => {
            this.form[key] = data[key]
          })
        }
      } catch (error) {
        console.error(error);
      }
    })();
  },
  methods: {
    async update() {
      try {
        const { data } = await this.form.patch('/api/profile/staff');

        await this.$store.dispatch('auth/updateUser', data)

        IziToast.success({ message: 'Ваша информация обновлена' });
      } catch (error) {
        console.error(error);
      }
    } 
  }
};
</script>


<style lang="scss" scoped>

</style>