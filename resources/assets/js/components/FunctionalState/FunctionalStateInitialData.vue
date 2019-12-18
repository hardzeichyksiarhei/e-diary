<template>
    <div class="initial-data-wrapper">
        <h4 class="mb-3">Физическое развитие и функциональное состояние</h4>
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
                                Для продолжения, заполните дополнительную информацию о себе. <router-link class="text-uppercase" :to="{ name: 'profile' }">Перейти к редактировать</router-link>
                            </div>
                        </div>
                    </div>
                    <h4 class="border-bottom pb-3">Соматометрические:</h4>
                    <div class="form-row d-flex align-items-end">
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="length_body">Длинна тела (рост) [см]</label>
                            <input type="text" class="form-control" id="length_body" name="length_body"
                                   :class="{ 'is-invalid': form.errors.has('length_body') }"
                                   v-model="form.length_body"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="length_body"></has-error>
                        </div>
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="mass_body">Масса тела (вес) [кг]</label>
                            <input type="text" class="form-control" id="mass_body" name="mass_body"
                                   :class="{ 'is-invalid': form.errors.has('mass_body') }"
                                   v-model="form.mass_body"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="mass_body"></has-error>
                        </div>
                    </div>
                    <h4 class="border-bottom py-3">Физиометрические:</h4>
                    <div class="form-row d-flex align-items-end">
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="sample_shtange">Проба Штанге</label>
                            <input type="text" class="form-control" id="sample_shtange" name="sample_shtange"
                                   :class="{ 'is-invalid': form.errors.has('sample_shtange') }"
                                   v-model="form.sample_shtange"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="sample_shtange"></has-error>
                        </div>
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="sample_genchi">Проба Генчи</label>
                            <input type="text" class="form-control" id="sample_genchi" name="sample_genchi"
                                   :class="{ 'is-invalid': form.errors.has('sample_genchi') }"
                                   v-model="form.sample_genchi"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="sample_genchi"></has-error>
                        </div>
                    </div>
                    <h4 class="border-bottom py-3"> - ортостаническая проба (ЧСС):</h4>
                    <div class="form-row d-flex align-items-end">
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="chss_lie">ЧСС в положении лежа за 1 минуту</label>
                            <input type="text" class="form-control" id="chss_lie" name="chss_lie"
                                   :class="{ 'is-invalid': form.errors.has('chss_lie') }"
                                   v-model="form.chss_lie"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="chss_lie"></has-error>
                        </div>
                        <div class="col-md-6 col-xs-12 mb-3">
                            <label for="chss_stand">ЧСС в положении стоя за 1 минуту</label>
                            <input type="text" class="form-control" id="chss_stand" name="chss_stand"
                                   :class="{ 'is-invalid': form.errors.has('chss_stand') }"
                                   v-model="form.chss_stand"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="chss_stand"></has-error>
                        </div>
                    </div>
                    <h4 class="border-bottom py-3"> - проба на дозированную нагрузку (ЧСС):</h4>
                    <div class="form-row d-flex align-items-end">
                        <div class="col-md-4 col-xs-12 mb-3">
                            <label for="chss_initial">ЧСС исходная уд/10 сек</label>
                            <input type="text" class="form-control" id="chss_initial" name="chss_initial"
                                   :class="{ 'is-invalid': form.errors.has('chss_initial') }"
                                   v-model="form.chss_initial"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="chss_initial"></has-error>
                        </div>
                        <div class="col-md-4 col-xs-12 mb-3">
                            <label for="chss_after_load">ЧСС после нагрузки уд/сек</label>
                            <input type="text" class="form-control" id="chss_after_load" name="chss_after_load"
                                   :class="{ 'is-invalid': form.errors.has('chss_after_load') }"
                                   v-model="form.chss_after_load"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="chss_after_load"></has-error>
                        </div>
                        <div class="col-md-4 col-xs-12 mb-3">
                            <label for="chss_restoring">ЧСС восстановления уд/сек</label>
                            <input type="text" class="form-control" id="chss_restoring" name="chss_restoring"
                                   :class="{ 'is-invalid': form.errors.has('chss_restoring') }"
                                   v-model="form.chss_restoring"
                                   placeholder="0"
                            >
                            <small class="form-text text-muted">Целое число</small>
                            <has-error :form="form" field="chss_restoring"></has-error>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div v-if="check && !user.has_profile" class="alert alert-warning mb-0" role="alert">
                                Для продолжения, заполните дополнительную информацию о себе. <router-link class="text-uppercase" :to="{ name: 'profile' }">Перейти к редактировать</router-link>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <v-button v-if="check && user.has_profile" class="btn-sm text-uppercase mr-3" type="primary" nativeType="button" :loading="form.busy" @click="updateInitialData">Обновить</v-button>
                <small>Последнее обновление: {{ updated_at }}</small>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  name: 'functional-state-initial-data',
  data: () => ({
    activeSemester: -1,
    form: new Form({
      length_body: '',
      mass_body: '',
      chss_lie: '',
      chss_stand: '',
      chss_initial: '',
      chss_after_load: '',
      chss_restoring: '',
      sample_shtange: '',
      sample_genchi: ''
    }),
    updated_at: ''
  }),
  computed: {
    ...mapGetters({
      user: 'auth/user',
      check: 'auth/check'
    })
  },
  created () {
    this.getInitialData(0)
  },
  methods: {
    async getInitialData (semester) {
      if (this.activeSemester === semester) return false
      this.activeSemester = semester
      try {
        // Fill the form with initialDataMeasurement data.
        const { data } = await axios.get(`/api/functional-state/initial-data/${semester}`)

        this.updated_at = data['updated_at']

        this.form.keys().forEach(key => {
          this.form[key] = data[key]
        })
      } catch (error) {
        console.error(error)
      }
    },
    async updateInitialData () {
      try {
        await this.form.patch(`/api/functional-state/calculation/${this.activeSemester}`)

        IziToast.success({ message: 'Информация обновлена' })
      } catch (error) {
        console.error(error)
      }
    }
  }
}
</script>

<style lang="less" scoped></style>
