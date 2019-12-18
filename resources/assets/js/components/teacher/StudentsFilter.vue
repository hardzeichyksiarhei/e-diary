<template>
  <div class="box box-primary">
     <div class="box-header with-border">
         <h3 class="box-title">Поиск</h3>
     </div>
     <div class="box-body">
         <form @submit.prevent="filter" @keydown="form.onKeydown($event)">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="first_name">Имя</label>
                        <input class="form-control" id="first_name" type="text" name="first_name" placeholder="Введите имя"
                            v-model="form.first_name"
                            :class="{ 'is-invalid': form.errors.has('first_name') }"
                        >
                        <has-error :form="form" field="first_name"></has-error>
                    </div>
                    <div class="col-md-4">
                        <label for="last_name">Фамилия</label>
                        <input class="form-control" id="last_name" type="text" name="last_name" placeholder="Введите фамилию"
                            v-model="form.last_name"
                            :class="{ 'is-invalid': form.errors.has('last_name') }"
                        >
                        <has-error :form="form" field="last_name"></has-error>
                    </div>
                    <div class="col-md-4">
                        <label for="email">E-mail</label>
                        <input class="form-control" id="email" type="text" name="email" placeholder="Введите e-mail"
                            v-model="form.email"
                            :class="{ 'is-invalid': form.errors.has('email') }"
                        >
                        <has-error :form="form" field="email"></has-error>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="faculty_id">Факультет</label>
                        <select class="form-control" id="faculty_id" name="faculty_id"
                                :class="{ 'is-invalid': form.errors.has('faculty_id') }"
                                v-model="form.faculty_id"
                        >
                            <option v-for="faculty in listFaculties" :value="faculty.id" :key="faculty.id">{{ faculty.name }}</option>
                        </select>
                        <has-error :form="form" field="faculty_id"></has-error>
                    </div>
                    <div class="col-md-2">
                        <label for="course">Курс</label>
                        <select class="form-control" id="course" name="course"
                                :class="{ 'is-invalid': form.errors.has('course') }"
                                v-model="form.course"
                        >
                            <option v-for="course in listCourses" :value="course.value" :key="course.value">{{ course.text }}</option>
                        </select>
                        <has-error :form="form" field="course"></has-error>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <checkbox v-model="form.my_student" name="my_student">
                    Только мои студенты
                </checkbox>
            </div>
            <v-button id="searchStudentBtn" class="btn-sm text-uppercase" type="primary" :loading="form.busy">Поиск</v-button>
         </form>
     </div>
  </div>
</template>

<script>
import axios from "axios";
import Form from "vform";

export default {
  name: "students-filter",
  data() {
    return {
      listCourses: [
        { text: "Выбрать...", value: null },
        { text: 1, value: 1 },
        { text: 2, value: 2 },
        { text: 3, value: 3 }
      ],
      listFaculties: [{ name: "Выбрать...", id: null }],
      form: new Form({
        first_name: "",
        last_name: "",
        email: "",
        my_student: false,
        faculty_id: null,
        course: null
      })
    };
  },
  created() {
    this.fetchInitialData();
  },
  methods: {
    async fetchInitialData() {
      try {
        let [listFaculties] = await Promise.all([axios.get("/api/faculty")]);

        this.listFaculties.push(...listFaculties.data);
      } catch (error) {
        console.error(error);
      }
    },
    async filter() {
      this.$emit('searchStudents', this.form);
    }
  }
};
</script>

<style lang="less" scoped></style>