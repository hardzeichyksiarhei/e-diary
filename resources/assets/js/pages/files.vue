<template>
  <div class="files-page">
    <div class="box box-primary">
      <div class="box-body">
        <div class="new-file">
          <form
            id="new-file-form"
            @submit.prevent="submitForm"
            :class="{ 'has-error': errors.length }"
          >
            <div class="new-file-field">
              <div class="new-file-name">
                <input
                  class="form-control"
                  name="name"
                  placeholder="Имя файла"
                  v-model="fileName"
                  required
                />
              </div>
              <div class="file">
                <label class="file-label">
                  <input class="file-input" type="file" ref="file" name="file" @change="addFile()" />
                  <span class="file-cta btn btn-success">
                    <i class="fa fa-upload"></i>&nbsp;Добавить файл
                  </span>
                </label>
              </div>
              <button type="submit" class="btn btn-primary">Загрузить файл</button>
            </div>
            <div v-for="(error, key) in errors" :key="key" class="help-block">{{ error }}</div>
          </form>
        </div>
      </div>
    </div>

    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="fa fa-docs"></i>
        <h3 class="box-title">Документы</h3>
      </div>
      <div class="box-body">
        <template v-if="files.total">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-no-hover">
              <thead>
                <tr>
                  <th id="name">Название</th>
                  <th id="birthday">Расширение</th>
                  <th id="created_at">Дата добавления</th>
                  <th>Опции</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="file in files.data" :key="file.id">
                  <td>
                    <div class="file-name">
                      <img class="document_thumb document_doc" alt="Document doc"
                        v-if="file.extension == 'doc' || file.extension == 'docx'" 
                        :src="domainURL + '/images/word.png'">
                      <img class="document_thumb document_pdf" alt="Document pdf"
                        v-if="file.extension == 'pdf'" 
                        :src="domainURL + '/images/pdf.png'">
                      <img v-if="file.extension == 'xlsx'" :src="domainURL + '/images/excel.png'" alt="Document excel" class="document_thumb document_excel">
                      <img v-if="['jpg', 'jpeg', 'png', 'gif'].includes(file.extension)" :src="domainURL + '/images/image.png'" alt="Document image" class="document_thumb document_image">
                      <p v-if="file.id !== editingFile.id">
                        {{ file.name }} <a href="javascript:void(0)" @click="editFile(file)"><small>Изменить</small></a>
                      </p>
                      <p v-else>
                        <input class="file-edit-name" @keyup.enter="endEditing(editingFile)" type="text" :placeholder="editingFile.name" v-model="editingFile.name">
                        <a href="javascript:void(0)" @click="endEditing(editingFile)"><small>Сохранить</small></a>
                      </p>
                    </div>
                  </td>
                  <td>{{ file.extension }}</td>
                  <td>{{ file.created_at }}</td>
                  <td class="options">
                    <div class="btn-group">
                      <a
                        class="btn btn-sm btn-success w-40"
                        title="Save"
                        :href="domainURL + '/documents/' + user.email.split('@')[0] + '_' + user.id + '/' + file.type + '/' + file.tmp_name + '.' + file.extension"
                        :download="file.name"
                        target="_blank"
                      >
                        <i class="fa fa-save fa-fw"></i>
                      </a>
                      <button
                        class="btn btn-sm btn-primary w-40"
                        title="Share"
                        data-toggle="modal"
                        data-target="#share-file"
                        @click="prepareToShare(file)"
                      >
                        <i class="fa fa-share fa-fw"></i>
                      </button>
                      <button
                        class="btn btn-sm btn-danger w-40 user-delete-btn"
                        title="Delete"
                        data-toggle="modal"
                        data-target="#remove-file"
                        @click="prepareToDelete(file)"
                      >
                        <i class="fa fa-trash fa-fw"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination :data="files" :limit="3" @pagination-change-page="fetchFiles" :show-disabled="true">
            <span slot="prev-nav"><i class="fa fa-angle-left"></i></span>
            <span slot="next-nav"><i class="fa fa-angle-right"></i></span>
          </pagination>
        </template>
        <div class="is-empty" v-else v-cloak>
          <img :src="domainURL + '/images/not_found.png'" alt="Folder empty" id="folder_empty">
        </div>
      </div>
    </div>

    <modal :modal-id="'share-file'" :hidden-handler="cancelSharing">
      <template v-slot:title>Открыть доступ к файлу "{{ sharingFile.name }}.{{ sharingFile.extension }}"</template>
      <template
        v-slot:body
      >
        <select2 id="mailbox-recipients" class="form-control select2"
          v-model="sharingUsers"
          :url="'/api/user/search/student'"
          multiple="multiple"
        >
        </select2>
      </template>
      <template v-slot:footer>
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button
          type="button"
          class="btn btn-primary"
          data-dismiss="modal"
          :disabled="sharingUsers.length == 0"
          @click="shareFile()"
        >Сохранить</button>
      </template>>
    </modal>

    <modal :modal-id="'remove-file'" :hidden-handler="cancelDeleting">
      <template v-slot:title>Удалить файл</template>
      <template
        v-slot:body
      >Вы действительно хотите удалить файл(иы)?</template>
      <template v-slot:footer>
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button
          type="button"
          class="btn btn-primary"
          data-dismiss="modal"
          @click="deleteFile()"
        >Удалить</button>
      </template>>
    </modal>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import { domainURL } from "~/config";

import Modal from "~/components/Modal";

export default {
  middleware: ["auth", "not-student"],

  name: "files",

  components: { Modal },

  data() {
    return {
      domainURL,

      files: {},

      formData: {},
      fileName: "",
      attachment: "",

      editingFile: {},
      deletingFile: {},
      sharingFile: {},

      sharingUsers: [],

      errors: []
    };
  },

  computed: {
    ...mapGetters({
      user: "auth/user"
    })
  },

  mounted() {
    this.fetchFiles(1);
  },

  methods: {
    isActive(tabItem) {
      return this.activeTab === tabItem;
    },

    setActiveTab(tabItem) {
      this.activeTab = tabItem;
    },

    async fetchFiles(page = 1) {
      try {
        this.$store.dispatch("loading/changeLoading");
        const { data } = await axios.get("api/files/?page=" + page);
        this.files = data;
      } catch (error) {
        console.error(error);
      } finally {
        this.$store.dispatch("loading/changeLoading");
      }
    },

    async submitForm() {
      this.errors = [];
      this.formData = new FormData();
      this.formData.append("name", this.fileName);
      this.formData.append("file", this.attachment);

      try {
        await axios.post("api/files/add", this.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        });
        this.resetForm();
        this.showNotification("Файл успешно загружен!", true);
      } catch (error) {
        if (error.response.status === 422) {
          this.errors = error.response.data.file;
        } else {
          this.showNotification(error.response.data.message, false);
        }
      } finally {
        this.fetchFiles(this.files.current_page || 1);
      }
    },

    addFile() {
      this.attachment = this.$refs.file.files[0];
      let filename = this.attachment ? this.attachment.name : "";
      this.fileName = filename.substring(0, filename.lastIndexOf("."));
    },

    prepareToDelete(file) {
      this.deletingFile = file;
    },

    cancelDeleting() {
      this.deletingFile = {};
    },

    async deleteFile() {
      try {
        await axios.delete("api/files/delete/" + this.deletingFile.id);
        this.showNotification("Файл успешно удален!", true);
      } catch (error) {
        this.errors = error.response.data.errors;
        this.showNotification(
          "Что-то пошло не так! Пожалуйста, попробуйте позже.",
          false
        );
      } finally {
        this.fetchFiles(this.files.current_page);
        this.cancelDeleting();
      }
    },

    editFile(file) {
      this.editingFile = Object.assign({}, file);
    },

    async endEditing(file) {
      this.editingFile = {};

      if (file.name.trim() === "") {
        alert("Имя файла не может быть пустым!");
      } else {
        let formData = new FormData();
        formData.append("name", file.name);
        formData.append("type", file.type);
        formData.append("extension", file.extension);

        try {
          const { data } = await axios.post(
            "api/files/edit/" + file.id,
            formData
          );

          if (data === true) {
            this.showNotification("Имя файла успешно изменено!", true);
            this.fetchFiles(this.files.current_page);
          }
        } catch (error) {
          this.errors = error.response.data.errors;
          this.showNotification(error.response.data.message, false);
        }
      }
    },

    prepareToShare(file) {
      this.sharingFile = file;
    },

    cancelSharing() {
      this.sharingFile = {};
      this.sharingUsers = [];
    },

    async shareFile() {
      if (!this.sharingUsers.length) return;

      console.log(this.sharingUsers);
      console.log(this.sharingFile);
    },

    showNotification(text, success) {
      let strErrors = "";
      for (let errorType in this.errors) {
        for (let error of this.errors[errorType]) {
          strErrors += error + "\n";
        }
      }

      if (success === true) {
        IziToast.success({ message: text });
      } else {
        IziToast.error({ message: strErrors || text });
      }

      this.clearErrors();
    },

    resetForm() {
      this.formData = {};
      this.fileName = "";
      this.attachment = "";
      this.$refs.file.value = "";
    },

    clearErrors() {
      this.errors = {};
    }
  }
};
</script>

<style lang="scss" scoped>
[v-cloak] {
  display: none;
}

.table {
  tr {
    td,
    th {
      &.select-files {
        max-width: 25px;
        text-align: center;
        .custom-checkbox {
          display: inline-block;
        }
      }
      &.options {
        .btn-group {
          width: 100%;
          display: flex;
        }
      }
    }
    td {
      .document_thumb {
        width: 30px;
        height: auto;
        margin-right: 10px;
      }
      .file-name {
        display: flex;
        align-items: center;
        p {
          margin-bottom: 0;
        }
      }
      .file-edit-name {
        margin-right: 5px;
      }
    }
  }
}

.new-file {
  &-field {
    display: flex;
    align-items: center;
  }
  &-name {
    flex-grow: 1;
  }
}

.file {
  &-label {
    margin-bottom: 0;
    margin: 0 10px;
  }
  &-input {
    display: none;
  }
}

.download-file {
  display: inline-block;
  padding: 10px;
  padding-bottom: 0;
}

.is-empty {
  display: flex;
  justify-content: center;
}
</style>