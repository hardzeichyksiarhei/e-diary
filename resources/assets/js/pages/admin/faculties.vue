<template>
  <div class="faculties-page">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary mb-3">
          <div class="box-header with-border">
            <h3 class="box-title">Факультеты</h3>
          </div>
          <div class="box-body">
            <form action>
              <div class="form-group" :class="{ 'has-error': errorsFaculty.length }">
                <div class="form-row">
                  <div class="col-md-10 col-xs-9">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Введите имя факультета"
                      v-model="faculty"
                    />
                    <div
                      v-for="(error, key) in errorsFaculty"
                      :key="key"
                      class="help-block"
                    >{{ error }}</div>
                  </div>
                  <div class="col-md-2 col-xs-3">
                    <button
                      class="btn btn-success btn-block"
                      type="button"
                      @click.prevent="save"
                    >Добавить</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Изменить факультеты</h3>
          </div>
          <div class="box-body">
            <form action>
              <div
                class="form-group"
                :class="{ 'has-error': errors[faculty.id].length }"
                v-for="faculty in faculties"
                :key="faculty.id"
              >
                <div class="form-row">
                  <div class="col-md-10 col-xs-9">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Введите имя факультета"
                      v-model="faculty.name"
                    />
                    <div
                      v-for="(error, key) in errors[faculty.id]"
                      :key="key"
                      class="help-block"
                    >{{ error }}</div>
                  </div>
                  <div class="col-md-2 col-xs-3">
                    <div class="btn-group w-100">
                      <button
                        class="btn d-block btn-primary w-50"
                        type="button"
                        @click.prevent="update(faculty.id)"
                      >
                        <i class="fa fa-refresh fa-fw"></i>
                      </button>
                      <button
                        class="btn d-block btn-danger w-50"
                        type="button"
                        @click.prevent="remove(faculty.id)"
                      >
                        <i class="fa fa-trash fa-fw"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  middleware: ["auth", "admin"],

  name: "faculties",

  metaInfo () {
    return { title: 'Факультеты' }
  },
  
  data: () => ({
    faculty: "",
    faculties: [],
    errorsFaculty: [],
    errors: {}
  }),
  created() {
    (async () => {
      try {
        const { data } = await axios.get("/api/faculty");
        this.faculties = data;

        data.map(item => this.$set(this.errors, item.id, []));
      } catch (errors) {
        console.log(errors);
      }
    })();
  },
  methods: {
    async save() {
      try {
        const { data } = await axios.post("/api/faculty", {
          name: this.faculty
        });

        this.$set(this.errors, data.id, []);

        this.faculties.push(data);

        this.faculty = "";

        IziToast.success({ message: "Факультет сохранен!" });

        this.errorsFaculty = [];
      } catch (e) {
        const { errors } = e.response.data;
        this.errorsFaculty = errors.name;
      }
    },
    async update(id) {
      try {
        const newFaculty = this.faculties.find(value => value.id === id);
        await axios.patch(`/api/faculty/${id}`, { name: newFaculty.name });

        IziToast.success({ message: "Факультет обновлен!" });

        this.errors[id] = [];
      } catch (e) {
        const { errors } = e.response.data;
        this.errors[id] = errors.name;
      }
    },
    async remove(id) {
      try {
        await axios.delete(`/api/faculty/${id}`);

        this.faculties = this.faculties.filter(value => {
          return value.id !== id;
        });

        IziToast.success({ message: "Факультет удален!" });
      } catch (errors) {
        console.log(errors.response);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.fa {
  margin-right: 0;
}
</style>
