<template>
  <modal :modal-id="'share-file'" :show-handler="showSharing" :hidden-handler="cancelSharing">
    <template v-slot:title>Открыть доступ к файлу "{{ file.name }}.{{ file.extension }}"</template>
    <template v-slot:body>
      <div class="share-file-controls-wrapper">
        <span>Выберите студента <b class="text-danger">*</b></span>
        <div class="share-file-controls">
          <select2
            id="mailbox-recipients"
            class="form-control select2"
            v-model="sharingUsersIds"
            :url="'/api/user/search/student'"
            multiple="multiple"
          ></select2>
          <button
            type="button"
            class="btn btn-primary"
            :disabled="sharingUsersIds.length == 0"
            @click="shareFile()"
          >Сохранить</button>
        </div>
      </div>
      <br />
      <template v-if="sharingUsers.length">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-no-hover">
            <thead>
              <tr>
                <th id="name">Имя</th>
                <th id="group">Группа</th>
                <th id="teacher">Преподаватель</th>
                <th>Опции</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in sharingUsers" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.profile.group || '–' }}</td>
                <td>{{ user.profile.teacher || '–' }}</td>
                <td>
                  <button
                    class="btn btn-sm btn-danger w-100"
                    title="Delete"
                    @click="removeShareUser(user.id)"
                  >
                    <i class="fa fa-trash fa-fw"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
    </template>
    <template v-slot:footer>
      <button type="button" class="btn btn-default" data-dismiss="modal">Выход</button>
    </template>>
  </modal>
</template>

<script>
import axios from "axios";
import Modal from "~/components/Modal";

export default {
  name: "sharing-file",

  components: { Modal },

  data() {
    return {
      sharingUsers: [],
      sharingUsersIds: []
    };
  },

  props: ["file"],

  destroyed() {
    this.sharingUsers = [];
    this.sharingUsersIds = [];
  },

  methods: {
    async getShareUsers() {
      try {
        const { data } = await axios.get(
          "/api/files/share/" + this.file.id + "/users"
        );
        this.sharingUsers = data;
      } catch (err) {
        console.error(err);
      }
    },

    async removeShareUser(userId) {
      try {
        const { data } = await axios.delete(
          "/api/files/share/" + this.file.id + "/users/" + userId
        );
        if (data) {
          this.sharingUsers = this.sharingUsers.filter(
            user => user.id !== userId
          );
        }
      } catch (err) {
        console.error(err);
      }
    },

    showSharing() {
      this.getShareUsers();
    },

    cancelSharing() {
      this.sharingUsers = [];
      this.sharingUsersIds = [];
      this.$emit("cancel-sharing");
    },

    async shareFile() {
      if (!this.sharingUsersIds.length) return;

      try {
        const { data } = await axios.post("/api/files/share", {
          user_ids: this.sharingUsersIds,
          file_id: this.file.id
        });

        if (data.attached.length) {
          this.getShareUsers();
        }

        this.sharingUsersIds = [];
      } catch (err) {
        console.error(err);
      }
    }
  }
};
</script>

<style lang="scss">
.share-file-controls-wrapper {
  > span {
    display: block;
    margin-bottom: 5px;
  }
}
.share-file-controls {
  display: flex;
  align-items: center;
  .select2 {
    flex-grow: 3;
  }
  .btn {
    margin-left: 10px;
  }
}
</style>
