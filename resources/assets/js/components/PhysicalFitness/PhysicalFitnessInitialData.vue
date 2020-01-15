<template>
  <div class="initial-data-wrapper">
    <h4 class="mb-3">Физическая подготовленность (ФП)</h4>
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li :class="{ 'active': activeSemester === 0 }">
          <a href="#" @click.prevent="getInitialData(0)">Исходные данные</a>
        </li>
        <li :class="{ 'active': activeSemester === 1 }">
          <a href="#" @click.prevent="getInitialData(1)">1 семестр</a>
        </li>
        <li :class="{ 'active': activeSemester === 2 }">
          <a href="#" @click.prevent="getInitialData(2)">2 семестр</a>
        </li>
        <li :class="{ 'active': activeSemester === 3 }">
          <a href="#" @click.prevent="getInitialData(3)">3 семестр</a>
        </li>
        <li :class="{ 'active': activeSemester === 4 }">
          <a href="#" @click.prevent="getInitialData(4)">4 семестр</a>
        </li>
        <li :class="{ 'active': activeSemester === 5 }">
          <a href="#" @click.prevent="getInitialData(5)">5 семестр</a>
        </li>
        <li :class="{ 'active': activeSemester === 6 }">
          <a href="#" @click.prevent="getInitialData(6)">6 семестр</a>
        </li>
      </ul>
      <div class="tab-content">
        <form @keydown="form.onKeydown($event)" @change="form.onKeydown($event)">
          <div class="form-row">
            <div class="col-md-12">
              <div v-if="check && !user.has_profile" class="alert alert-warning mb-0" role="alert">
                Для продолжения, заполните дополнительную информацию о себе.
                <router-link
                  class="text-uppercase"
                  :to="{ name: 'profile' }"
                >Перейти к редактировать</router-link>
              </div>
            </div>
          </div>
          <h4 class="border-bottom py-3">Физиометрические:</h4>
          <div class="form-row d-flex align-items-end">
            <div class="col-md-2 col-xs-12 mb-3">
              <label for="length_body">Возраст</label>
              <input
                type="text"
                class="form-control"
                id="age"
                name="age"
                :class="{ 'is-invalid': form.errors.has('age') }"
                v-model="form.age"
                placeholder="0"
              />
              <small class="form-text text-muted">Целое число</small>
              <has-error :form="form" field="length_body"></has-error>
            </div>
            <div class="col-md-5 col-xs-12">
              <div class="form-group" :class="{ 'has-error': form.errors.has('long_jump') }">
                <label for="long_jump">Прыжок в длину с места</label>
                <input
                  type="text"
                  class="form-control"
                  id="long_jump"
                  name="long_jump"
                  :class="{ 'is-invalid': form.errors.has('long_jump') }"
                  v-model="form.long_jump"
                  placeholder="0"
                />
                <small class="form-text text-muted">Целое число (сантиметры)</small>
                <has-error :form="form" field="long_jump"></has-error>
              </div>
            </div>
            <div class="col-md-5 col-xs-12 mb-3">
              <div
                class="form-group"
                :class="{ 'has-error': form.errors.has('torso_inclination') }"
              >
                <label for="torso_inclination">Наклон туловища вперед</label>
                <input
                  type="text"
                  class="form-control"
                  id="torso_inclination"
                  name="torso_inclination"
                  :class="{ 'is-invalid': form.errors.has('torso_inclination') }"
                  v-model="form.torso_inclination"
                  placeholder="0"
                />
                <small class="form-text text-muted">Целое число (сантиметры)</small>
                <has-error :form="form" field="torso_inclination"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12 mb-3">
              <div class="form-group" :class="{ 'has-error': form.errors.has('run_shuttle') }">
                <label for="run_shuttle">Челночный бег 4x9 метров</label>
                <input
                  type="text"
                  class="form-control"
                  id="run_shuttle"
                  name="run_shuttle"
                  :class="{ 'is-invalid': form.errors.has('run_shuttle') }"
                  v-model="form.run_shuttle"
                  placeholder="0"
                />
                <small class="form-text text-muted">Десятичное число (секунды)</small>
                <has-error :form="form" field="run_shuttle"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12 mb-3" v-if="user.profile.gender === 'man'">
              <div class="form-group" :class="{ 'has-error': form.errors.has('pull_up') }">
                <label for="pull_up">Подтягивание на перекладине</label>
                <input
                  type="text"
                  class="form-control"
                  id="pull_up"
                  name="pull_up"
                  :class="{ 'is-invalid': form.errors.has('pull_up') }"
                  v-model="form.pull_up"
                  placeholder="0"
                />
                <small class="form-text text-muted">Целое число (количество раз)</small>
                <has-error :form="form" field="pull_up"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12 mb-3">
              <div class="form-group" :class="{ 'has-error': form.errors.has('press') }">
                <label for="press">Поднимание туловища из положения лежа на спине за 60 с</label>
                <input
                  type="text"
                  class="form-control"
                  id="press"
                  name="press"
                  :class="{ 'is-invalid': form.errors.has('press') }"
                  v-model="form.press"
                  placeholder="0"
                />
                <small class="form-text text-muted">Целое число (количество раз)</small>
                <has-error :form="form" field="press"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12 mb-3">
              <div class="form-group" :class="{ 'has-error': form.errors.has('push_up') }">
                <label for="push_up">Сгибание рук в упоре лежа</label>
                <input
                  type="text"
                  class="form-control"
                  id="push_up"
                  name="push_up"
                  :class="{ 'is-invalid': form.errors.has('push_up') }"
                  v-model="form.push_up"
                  placeholder="0"
                />
                <small class="form-text text-muted">Целое число (количество раз)</small>
                <has-error :form="form" field="push_up"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12 mb-3">
              <div class="form-group" :class="{ 'has-error': form.errors.has('run_short') }">
                <label for="run_short">Бег 30 метров</label>
                <input
                  type="text"
                  class="form-control"
                  id="run_short"
                  name="run_short"
                  :class="{ 'is-invalid': form.errors.has('run_short') }"
                  v-model="form.run_short"
                  placeholder="0"
                />
                <small class="form-text text-muted">Десятичное число (секунды)</small>
                <has-error :form="form" field="run_short"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12 mb-3">
              <div class="form-group" :class="{ 'has-error': form.errors.has('run_long') }">
                <label for="run_long">Бег 1500/3000 метров</label>
                <input
                  type="text"
                  class="form-control"
                  id="run_long"
                  name="run_long"
                  :class="{ 'is-invalid': form.errors.has('run_long') }"
                  v-model="form.run_long"
                  placeholder="0"
                />
                <small class="form-text text-muted">Минуты и секунды</small>
                <has-error :form="form" field="run_long"></has-error>
              </div>
            </div>
            <div class="col-md-4 col-xs-12 mb-3">
              <label>Плавание 50 метров (секунды или метры)</label>
              <div class="form-row">
                <div class="col-md-6 col-xs-12">
                  <div class="form-group" :class="{ 'has-error': form.errors.has('swimming_s') }">
                    <input
                      type="text"
                      class="form-control"
                      id="swimming_s"
                      name="swimming_s"
                      :class="{ 'is-invalid': form.errors.has('swimming_s') }"
                      v-model="form.swimming_s"
                      placeholder="0"
                      @input="form.swimming_m = 0"
                    />
                    <small class="form-text text-muted">Десятичное число (секунды)</small>
                    <has-error :form="form" field="swimming_50"></has-error>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="form-group" :class="{ 'has-error': form.errors.has('swimming_m') }">
                    <input
                      type="text"
                      class="form-control"
                      id="swimming_m"
                      name="swimming_m"
                      :class="{ 'is-invalid': form.errors.has('swimming_m') }"
                      v-model="form.swimming_m"
                      placeholder="0"
                      @input="form.swimming_s = 0"
                    />
                    <small class="form-text text-muted">Метры (12 и менее, 25, 50)</small>
                    <has-error :form="form" field="swimming_m"></has-error>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12">
              <div v-if="check && !user.has_profile" class="alert alert-warning mb-0" role="alert">
                Для продолжения, заполните дополнительную информацию о себе.
                <router-link
                  class="text-uppercase"
                  :to="{ name: 'profile' }"
                >Перейти к редактировать</router-link>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="box-footer">
        <v-button
          v-if="check && user.has_profile"
          class="btn-sm text-uppercase mr-3"
          type="primary"
          nativeType="button"
          :loading="form.busy"
          @click="updateInitialData"
        >Обновить</v-button>
        <small>Последнее обновление: {{ updated_at }}</small>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  name: "physical-fitness-initial-data",

  data: () => ({
    activeSemester: -1,
    form: new Form({
      age: "",
      long_jump: "",
      torso_inclination: "",
      run_shuttle: "",
      pull_up: "",
      press: "",
      push_up: "",
      run_short: "",
      run_long: "",
      swimming_s: "",
      swimming_m: ""
    }),
    updated_at: ""
  }),
  computed: {
    ...mapGetters({
      user: "auth/user",
      check: "auth/check"
    })
  },
  created() {
    this.getInitialData(0);
  },
  methods: {
    async getInitialData(semester) {
      if (this.activeSemester === semester) return false;
      this.activeSemester = semester;
      try {
        // Fill the form with initialDataMeasurement data.
        const { data } = await axios.get(
          `/api/physical-fitness/initial-data/${semester}`
        );

        this.updated_at = data["updated_at"];

        this.form.keys().forEach(key => {
          this.form[key] = data[key];
        });
        if (!this.form.age) this.form.age = this.user.age;
      } catch (error) {
        console.error(error);
      }
    },
    async updateInitialData() {
      try {
        await this.form.patch(
          `/api/physical-fitness/calculation/${this.activeSemester}`
        );

        IziToast.success({ message: "Информация обновлена" });
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style scoped>
</style>