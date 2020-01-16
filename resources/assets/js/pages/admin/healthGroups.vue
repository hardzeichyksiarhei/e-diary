<template>
  <div class="health-group-page">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Добавить медицинскую группу здоровья</h3>
          </div>
          <div class="box-body">
            <form action>
              <div class="form-group" :class="{ 'has-error': errorsHealthGroups.length }">
                <div class="form-row">
                  <div class="col-md-10 col-xs-9">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Введите мед. группу здоровья"
                      v-model="healthGroup"
                    />
                    <div
                      v-for="(error, key) in errorsHealthGroups"
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
            <h3 class="box-title">Изменить медицинские группы здоровья</h3>
          </div>
          <div class="box-body">
            <form action>
              <div
                class="form-group"
                :class="{ 'has-error': errors[healthGroup.id].length }"
                v-for="healthGroup in healthGroups"
                :key="healthGroup.id"
              >
                <div class="form-row">
                  <div class="col-md-10 col-xs-9">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Введите мед. группу здоровья"
                      v-model="healthGroup.name"
                    />
                    <div
                      v-for="(error, key) in errors[healthGroup.id]"
                      :key="key"
                      class="help-block"
                    >{{ error }}</div>
                  </div>
                  <div class="col-md-2 col-xs-3">
                    <div class="btn-group w-100">
                      <button
                        class="btn btn-primary d-block w-50"
                        type="button"
                        @click.prevent="update(healthGroup.id)"
                      >
                        <i class="fa fa-refresh fa-fw"></i>
                      </button>
                      <button
                        class="btn btn-danger d-block w-50"
                        type="button"
                        @click.prevent="remove(healthGroup.id)"
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

  name: "health-groups",

  metaInfo() {
    return { title: "Мед. группы здоровья" };
  },

  data: () => ({
    healthGroup: "",
    healthGroups: [],
    errorsHealthGroups: [],
    errors: {}
  }),
  created() {
    (async () => {
      try {
        let { data } = await axios.get("/api/health-group");
        this.healthGroups = data;

        data.map(item => this.$set(this.errors, item.id, []));
      } catch (errors) {
        console.log(errors);
      }
    })();
  },
  methods: {
    async save() {
      try {
        let { data } = await axios.post("/api/health-group", {
          name: this.healthGroup
        });

        this.$set(this.errors, data.id, []);

        this.healthGroups.push(data);

        this.healthGroup = "";

        IziToast.success({ message: "Мед. группа сохранена!" });

        this.errorsHealthGroups = [];
      } catch (e) {
        let { errors } = e.response.data;
        this.errorsHealthGroups = errors.name;
      }
    },
    async update(id) {
      try {
        let newHealthGroup = this.healthGroups.find(value => value.id === id);
        await axios.patch(`/api/health-group/${id}`, {
          name: newHealthGroup.name
        });

        IziToast.success({ message: "Мед. группа обновлена!" });

        this.errors[id] = [];
      } catch (e) {
        let { errors } = e.response.data;
        this.errors[id] = errors.name;
      }
    },
    async remove(id) {
      try {
        await axios.delete(`/api/health-group/${id}`);

        this.healthGroups = this.healthGroups.filter(value => {
          return value.id !== id;
        });

        IziToast.success({ message: "Мед. группа удалена!" });
      } catch (errors) {
        console.log(errors);
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