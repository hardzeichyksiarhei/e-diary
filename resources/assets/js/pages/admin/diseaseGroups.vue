<template>
    <div class="disease-groups-page">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Добавить группу заболевания</h3>
                    </div>
                    <div class="box-body">
                        <form action="">
                          <div class="form-group" :class="{ 'has-error': errorsDiseaseGroups.name.length }">
                            <div class="form-row">
                              <div class="col-md-10 col-xs-9">
                                <input type="text" class="form-control" placeholder="Введите название группы заболеваний"
                                    v-model="diseaseGroup.name"
                                >
                                <div v-for="(error, key) in errorsDiseaseGroups.name" :key="key" class="help-block">{{ error }}</div>
                              </div>
                              <div class="col-md-2 col-xs-3">
                                <button class="btn btn-success btn-block" type="button" @click.prevent="save">Добавить</button>
                              </div>
                            </div>
                          </div>
                          <div class="form-group" :class="{ 'has-error': errorsDiseaseGroups.text.length }">
                            <textarea class="form-control v-resize" rows="3" v-model="diseaseGroup.text" placeholder="Введите текст группы заболеваний"></textarea>
                            <div v-for="(error, key) in errorsDiseaseGroups.text" :key="key" class="help-block">{{ error }}</div>
                          </div>
                        </form>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Изменить группы заболевания</h3>
                    </div>
                    <div class="box-body">
                        <form action="">
                            <div v-for="diseaseGroup in diseaseGroups" :key="diseaseGroup.id" class="diseaseItem">
                                <div class="form-group" :class="{ 'has-error': errors[diseaseGroup.id].name.length }">
                                    <div class="form-row">
                                        <div class="col-md-10 col-xs-9">
                                            <input type="text" class="form-control" placeholder="Input faculty name"
                                                v-model="diseaseGroup.name"
                                            >
                                            <div v-for="(error, key) in errors[diseaseGroup.id].name" :key="key" class="help-block">{{ error }}</div>
                                        </div>
                                        <div class="col-md-2 col-xs-3">
                                            <div class="btn-group w-100">
                                                <button class="btn btn-primary d-block w-50" type="button"
                                                    @click.prevent="update(diseaseGroup.id)"
                                                ><i class="fa fa-refresh fa-fw"></i></button>
                                                <button class="btn btn-danger d-block w-50" type="button"
                                                    @click.prevent="remove(diseaseGroup.id)"
                                                ><i class="fa fa-trash fa-fw"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" :class="{ 'has-error': errors[diseaseGroup.id].text.length }">
                                    <textarea class="form-control v-resize" rows="3" v-model="diseaseGroup.text"></textarea>
                                    <div v-for="(error, key) in errors[diseaseGroup.id].text" :key="key" class="help-block">{{ error }}</div>
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
import axios from 'axios'

export default {
  name: 'disease-groups',
  data: () => ({
    diseaseGroup: {
      name: '',
      text: ''
    },
    diseaseGroups: [],
    errorsDiseaseGroups: {
      name: [],
      text: []
    },
    errors: {}
  }),
  created () {
    (async () => {
      try {
        const { data } = await axios.get('/api/disease-group')
        this.diseaseGroups = data

        data.map((item) => this.$set(this.errors, item.id, { name: [], text: [] }))
      } catch (errors) {
        console.log(errors)
      }
    })()
  },
  methods: {
    async save () {
      try {
        const { data } = await axios.post('/api/disease-group', this.diseaseGroup)

        this.$set(this.errors, data.id, { name: [], text: [] })

        this.diseaseGroups.push(data)

        this.diseaseGroup = {
          name: '',
          text: ''
        }

        IziToast.success({ message: 'Successfully saved new medical disease group!' })

        this.errorsDiseaseGroups = {
          name: [],
          text: []
        }
      } catch (e) {
        const { errors } = e.response.data
        for (const key in this.errorsDiseaseGroups) {
          if (this.errorsDiseaseGroups.hasOwnProperty(key)) {
            this.errorsDiseaseGroups[key] = []
            const errorMessage = errors[key]
            if (errorMessage) this.errorsDiseaseGroups[key] = errorMessage
          }
        }
      }
    },
    async update (id) {
      try {
        const newDiseaseGroup = this.diseaseGroups.find(value => value.id === id)
        await axios.patch(`/api/disease-group/${id}`, newDiseaseGroup)

        IziToast.success({ message: 'Successfully updated medical disease group!' })

        this.clearError(id)
      } catch (e) {
        const { errors } = e.response.data
        for (const key in this.errors[id]) {
          if (this.errors[id].hasOwnProperty(key)) {
            this.errors[id][key] = []
            const errorMessage = errors[key]
            if (errorMessage) this.errors[id][key] = errorMessage
          }
        }
      }
    },
    async remove (id) {
      try {
        await axios.delete(`/api/disease-group/${id}`)

        this.diseaseGroups = this.diseaseGroups.filter((value) => {
          return value.id !== id
        })

        IziToast.success({ message: 'Successfully removed medical disease group!' })
      } catch (errors) {
        console.log(errors)
      }
    },
    clearError (id) {
      for (const key in this.errors[id]) {
        if (this.errors[id].hasOwnProperty(key)) {
          this.errors[id][key] = []
        }
      }
    }
  }
}
</script>

<style lang="scss" scoped>
    .fa {
        margin-right: 0;
    }
    .diseaseItem {
        border-bottom: 1px solid #cdcdcd;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        &:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    }
</style>
