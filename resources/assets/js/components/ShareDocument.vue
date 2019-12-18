<template>
  <div class="share-modal" @click.self="close">
    <div class="share-document">
      <div class="share-document__head">
        <form @submit.prevent="save">
          <div class="form-row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="teacher_id">Пользователи <b class="text-danger">*</b></label>
                <select2 class="form-control select2"
                  v-model="user_ids"
                  :url="`/api/files/${file_id}/share/search`"
                  :settings="{
                    closeOnSelect: false
                  }"
                  multiple="multiple"
                ></select2>
              </div>
            </div>
          </div>
          <v-button class="btn-sm text-uppercase" type="primary">Сохранить</v-button>
        </form>
      </div>
      <div class="share-document__body">
        <span class="share-document__count">Всего записей: {{ users.length }}</span>
        <div class="share-document-list">
          <div class="share-document-item" v-for="user in users" :key="user.id">
            <a href="javascript:void(0)" @click.prevent="$router.push({
              name: user.role === 'student' ? 'profile.student' : 'profile.staff',
              params: { id: user.id }
            })">{{ user.name }}</a>
            <button class="share-document__delete" @click="remove(user.id)"><i class="fa fa-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'ShareDocument',

  props: ['file_id'],

  data () {
    return {
      users: [],
      user_ids: []
    }
  },

  created () {
    this.init()
  },

  methods: {
    close () {
      this.$emit('close')
    },

    async init () {
      try {
        this.$store.dispatch('loading/changeLoading')
        const { data } = await axios.get(`api/files/${this.file_id}/share`)
        this.users = data
      } catch (errors) {

      } finally {
        this.$store.dispatch('loading/changeLoading')
      }
    },

    async save () {
      try {
        this.$store.dispatch('loading/changeLoading')
        const { data } = await axios.post('api/files/share', {
          file_id: this.file_id,
          user_ids: this.user_ids
        })

        this.users = data
        this.user_ids = []
      } catch (errors) {

      } finally {
        this.$store.dispatch('loading/changeLoading')
      }
    },

    async remove (userId) {
      try {
        this.$store.dispatch('loading/changeLoading')
        const { data } = await axios.delete(`api/files/${this.file_id}/share/${userId}`)

        this.users = data
      } catch (errors) {} finally {
        this.$store.dispatch('loading/changeLoading')
      }
    }
  }
}

</script>

<style lang="scss" scoped>
  .share-modal {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .8);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px;
  }

  .share-document {
    width: 70%;
    max-height: 90vh;
    max-width: 800px;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    &__head {
      width: 100%;
      position: sticky;
      padding: 20px 30px;
      border-bottom: 1px solid #f1f1f1;
    }
    &__count {
      display: inline-block;
      margin-bottom: 10px;
    }
    &__body {
      overflow-y: auto;
      padding: 30px;
    }
    &__delete {
      background: transparent;
      border: none;
      color:rgb(161, 29, 29);
      font-size: 18px;
    }
  }

  .share-document-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 10px;
  }

  .share-document-item {
    padding: 10px;
    border: 1px solid #f1f1f1;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
</style>
