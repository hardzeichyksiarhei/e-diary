<template>
  <form @submit.prevent="update" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)">
    <div class="form-row">
      <div class="col-md-2 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('birthday') }">
          <label for="birthday">
            Дата рождения
            <b class="text-danger">*</b>
          </label>
          <input
            type="text"
            class="form-control"
            id="birthday"
            name="birthday"
            placeholder="дд/мм/гггг"
            v-model="form.birthday"
          />
          <has-error :form="form" field="birthday"></has-error>
        </div>
      </div>
      <div class="col-md-2 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('gender') }">
          <label for="gender">
            Пол
            <b class="text-danger">*</b>
          </label>
          <select
            class="form-control"
            id="gender"
            name="gender"
            :class="{ 'is-invalid': form.errors.has('gender') }"
            v-model="form.gender"
          >
            <option value="null">Выбрать...</option>
            <option
              v-for="gender in listGender"
              :value="gender.value"
              :key="gender.id"
            >{{ gender.text }}</option>
          </select>
          <has-error :form="form" field="gender"></has-error>
        </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('faculty_id') }">
          <label for="faculty_id">
            Факультет
            <b class="text-danger">*</b>
          </label>
          <select
            class="form-control"
            id="faculty_id"
            name="faculty_id"
            :class="{ 'is-invalid': form.errors.has('faculty_id') }"
            v-model="form.faculty_id"
          >
            <option value="null">Выбрать...</option>
            <option
              v-for="faculty in listFaculties"
              :value="faculty.id"
              :key="faculty.id"
            >{{ faculty.name }}</option>
          </select>
          <has-error :form="form" field="faculty_id"></has-error>
        </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('teacher_id') }">
          <label for="teacher_id">
            Преподаватель
            <b class="text-danger">*</b>
          </label>
          <select2 class="form-control select2" :options="listTeachers" v-model="form.teacher_id"></select2>
          <has-error :form="form" field="teacher_id"></has-error>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-2 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('course') }">
          <label for="course">
            Курс
            <b class="text-danger">*</b>
          </label>
          <select
            class="form-control"
            id="course"
            name="course"
            :class="{ 'is-invalid': form.errors.has('course') }"
            v-model="form.course"
          >
            <option value="null">Выбрать...</option>
            <option
              v-for="course in listCourses"
              :value="course.value"
              :key="course.value"
            >{{ course.text }}</option>
          </select>
          <has-error :form="form" field="course"></has-error>
        </div>
      </div>
      <div class="col-md-2 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('group') }">
          <label for="group">
            Группа
            <b class="text-danger">*</b>
          </label>
          <input
            type="text"
            class="form-control"
            id="group"
            name="group"
            :class="{ 'is-invalid': form.errors.has('group') }"
            v-model="form.group"
          />
          <has-error :form="form" field="group"></has-error>
        </div>
      </div>
      <div class="col-md-8 col-xs-12">
        <div class="form-group" :class="{ 'has-error': form.errors.has('health_group_id') }">
          <label for="medicalHealthTeam">
            Медицинская группа здоровья
            <b class="text-danger">*</b>
          </label>
          <select
            class="form-control"
            id="health_group_id"
            name="health_group_id"
            :class="{ 'is-invalid': form.errors.has('health_group_id') }"
            v-model="form.health_group_id"
          >
            <option value="null">Выбрать...</option>
            <option
              v-for="medicalHealthTeam in listHealthGroups"
              :value="medicalHealthTeam.id"
              :key="medicalHealthTeam.id"
            >{{ medicalHealthTeam.name }}</option>
          </select>
          <has-error :form="form" field="health_group_id"></has-error>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-xs-12">
        <div class="form-group">
          <label for="disease">Заболевание</label>
          <textarea class="form-control" id="disease" rows="5" v-model="form.disease"></textarea>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-12">
        <label class="d-block mb-2">Группы заболеваний:</label>
        <table class="table table-condensed disease-table">
          <tbody>
            <tr v-for="groupDiseases in listDiseaseGroups" :key="groupDiseases.id">
              <td>
                <div class="custom-control custom-checkbox">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    :id="groupDiseases.id"
                    :value="groupDiseases.id"
                    v-model="form.disease_group_ids"
                  />
                  <label :for="groupDiseases.id" class="custom-control-label"></label>
                </div>
              </td>
              <td>{{ groupDiseases.name }}</td>
              <td>{{ groupDiseases.text }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <v-button class="btn-sm text-uppercase" type="primary" :loading="form.busy">Обновить</v-button>
  </form>
</template>

<script>
import Form from "vform";
import axios from "axios";
import { mapGetters } from "vuex";
import InputmaskDate from "inputmask/dist/inputmask/inputmask.date.extensions";

export default {
  name: "update-student-profile-data",
  data: () => ({
    listGender: [
      { text: "Мужской", value: "man" },
      { text: "Женский", value: "woman" }
    ],
    listCourses: [
      { text: 1, value: 1 },
      { text: 2, value: 2 },
      { text: 3, value: 3 }
    ],
    listDiseaseGroups: [],
    listHealthGroups: [],
    listFaculties: [],
    listTeachers: [],
    form: new Form({
      birthday: "",
      gender: null,
      faculty_id: null,
      teacher_id: null,
      course: null,
      group: "",
      health_group_id: null,
      disease: "",
      disease_group_ids: []
    })
  }),
  computed: {
    ...mapGetters({
      user: "auth/user"
    })
  },
  mounted() {
    let ageSelector = document.getElementById("birthday");
    InputmaskDate({
      alias: "dd/mm/yyyy",
      placeholder: "дд/мм/гггг"
    }).mask(ageSelector);
  },
  created() {
    this.fetchInitialData();
  },
  methods: {
    async fetchInitialData() {
      try {
        let [
          listTeachers,
          listFaculties,
          listDiseaseGroups,
          listHealthGroups
        ] = await Promise.all([
          axios.get("/api/user/teacher"),
          axios.get("/api/faculty"),
          axios.get("/api/disease-group"),
          axios.get("/api/health-group")
        ]);

        this.listTeachers = _.map(listTeachers.data, function(obj) {
          obj.text = obj.text || obj.name;
          return obj;
        });

        this.listTeachers.unshift({ id: "null", text: "Выбрать..." });

        this.listFaculties = listFaculties.data;
        this.listDiseaseGroups = listDiseaseGroups.data;
        this.listHealthGroups = listHealthGroups.data;

        // Fill the form with profileStudent data.
        const { data } = await axios.get("/api/profile/student");
        
        if (data) {
          this.form.keys().forEach(key => {
            this.form[key] = data[key];
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async update() {
      const { data } = await this.form.patch("/api/profile/student");

      await this.$store.dispatch("auth/updateUser", data);

      IziToast.success({ message: "Информация обновлена" });
    }
  }
};
</script>


<style lang="scss" scoped>
table.disease-table {
  tbody tr td {
    &:nth-child(1) {
      width: 10px;
    }
    &:nth-child(2) {
      width: 100px;
    }
  }
}
</style>