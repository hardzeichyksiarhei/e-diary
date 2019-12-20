<template>
  <div class="files-page">
    <div class="box box-primary">
      <div class="box-body">
        <div class="new-file">
          <form id="new-file-form" @submit.prevent="submitForm" :class="{ 'has-error': errors.length }">
            <div class="new-file-field">
              <div class="new-file-name">
                <input class="form-control" name="name" placeholder="Имя файла" v-model="fileName" required>
              </div>
              <div class="file">
                <label class="file-label">
                  <input class="file-input" type="file" ref="file" name="file" @change="addFile()">
                  <span class="file-cta btn btn-success"><i class="fa fa-upload"></i>&nbsp;Добавить файл</span>
                </label>
              </div>
              <button type="submit" class="btn btn-primary">Загрузить файл</button>
            </div>
            <div v-for="(error, key) in errors" :key="key" class="help-block">{{ error }}</div>            
          </form>
        </div>
      </div>
    </div>

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li :class="{'active': isActive('document')}" @click="getFiles('document')">
            <a href="#">
                <span class="icon is-small"><i class="fa fa-file-text-o"></i></span>
                <span>Документы</span>
            </a>
        </li>
        <li :class="{'active': isActive('image')}" @click="getFiles('image')">
            <a href="#">
                <span class="icon is-small"><i class="fa fa-image"></i></span>
                <span>Изображения</span>
            </a>
        </li>
      </ul>

      <div class="tabs-details">
          <div class="columns">

              <div class="is-empty" v-if="files.total == 0" v-cloak>
                <img :src="domainURL + '/images/not_found.png'" alt="Folder empty" id="folder_empty">
              </div>

              <div class="column" :class="{
                'image' : isImage,
                'document' : isDocument,
              }" v-for="f in files.data" :key="f.id" v-cloak>
                  <div class="card">
                    <div class="card-image">
                      <button class="delete delete-file" title="Delete" data-toggle="modal" data-target="#remove-file" @click="prepareToDelete(f)"></button>

                      <figure class="image image-bg" 
                        :style="'background-image: url(' + domainURL + '/documents/' + user.email.split('@')[0] + '_' + user.id + '/' + f.type + '/' + f.tmp_name + '.' + f.extension + ');'"
                        v-if="f.type == 'image'" 
                        @click="showModal(f)">
                      </figure>

                      <div v-if="f.type == 'document'" class="document_block">
                          <figure class="image is-4by3">
                              <img id="document_doc" alt="Document doc"
                                v-if="f.extension == 'doc' || f.extension == 'docx'" 
                                :src="domainURL + '/images/word.png'">
															<img id="document_pdf" alt="Document pdf"
                                v-if="f.extension == 'pdf'" 
                                :src="domainURL + '/images/pdf.png'">
                              <img v-if="f.extension == 'xlsx'" :src="domainURL + '/images/excel.jpg'" alt="Document image" id="document_image">
                          </figure>
                          <a class="download-file is-primary" :href="domainURL + '/documents/' + user.email.split('@')[0] + '_' + user.id + '/' + f.type + '/' + f.tmp_name + '.' + f.extension" :download="f.name" target="_blank">
                              <i class="fa fa-download" aria-hidden="true"></i>
                              &nbsp;Скачать
                          </a>
                      </div>
                    </div>
                    <div class="card-content">
                      <p v-if="f.id !== editingFile.id" @dblclick="editFile(f)" :title="'Double click for editing filename'">
                          {{ f.name + '.' + f.extension}}
                      </p>
                      <input class="input" v-if="f.id === editingFile.id" @keyup.enter="endEditing(editingFile)" type="text" :placeholder="editingFile.name" v-model="editingFile.name">
                      <time datetime="2016-1-1">{{ f.created_at }}</time>
                    </div>
                  </div>
              </div>
          </div>
          <pagination :data="files" :limit="3" @pagination-change-page="fetchFile" :show-disabled="true">
            <span slot="prev-nav"><i class="fa fa-angle-left"></i></span>
            <span slot="next-nav"><i class="fa fa-angle-right"></i></span>
          </pagination>
      </div>
    </div>
    <div class="modal fade" id="remove-file" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Удаление файла</h4>
          </div>
          <div class="modal-body">Вы действительно хотите удалить этот файл?</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" @click="cancelDeleting">Отмена</button>
            <button type="button" class="btn btn-primary" @click="deleteFile" data-dismiss="modal">Удалить</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  import axios from 'axios'
  import { mapGetters } from 'vuex'
  import { domainURL } from '~/config'

  export default {

    middleware: ['auth', 'not-student'],

    name: "files",

    data () {
      return {
        domainURL,

        files: {},

        activeTab: 'document',
        isImage: false,
        isDocument: true,

        formData: {},
        fileName: '',
        attachment: '',

        editingFile: {},
        deletingFile: {},

        errors: []
      }
    },

    computed: {
      ...mapGetters({
        'user': 'auth/user'
      })
    },

    mounted() {
      this.fetchFile(1, this.activeTab);
    },

    methods: {
      isActive(tabItem) {
          return this.activeTab === tabItem;
      },

      setActiveTab(tabItem) {
          this.activeTab = tabItem;
      },

      async fetchFile(page = 1, type = this.activeTab) {
          try {
            this.$store.dispatch("loading/changeLoading");
            const { data } = await axios.get('api/files/' + type + '?page=' + page);
            this.files = data;
          } catch(error) {
              console.error(error);
          } finally {
            this.$store.dispatch("loading/changeLoading");
          }
      },

      getFiles(type) {
        this.files = {};
        this.setActiveTab(type);
        this.fetchFile(1, type);

        this.isImage = this.activeTab === 'image'
        this.isDocument = this.activeTab === 'document'
      },

      async submitForm() {
        this.errors = [];
        this.formData = new FormData();
        this.formData.append('name', this.fileName);
        this.formData.append('file', this.attachment);

        try {
          await axios.post('api/files/add', this.formData, { 
            headers: {
              'Content-Type': 'multipart/form-data'
              } 
            });
          this.resetForm();
          this.showNotification('Файл успешно загружен!', true);
        } catch (error) {
          if (error.response.status === 422) {
            this.errors = error.response.data.file;
          } else {
            this.showNotification(error.response.data.message, false);
          }
        } finally {
          this.fetchFile(1, this.activeTab);
        }
      },

      addFile() {
          this.attachment = this.$refs.file.files[0];
          let filename = this.attachment ? this.attachment.name : '';
          this.fileName = filename.substring(0, filename.lastIndexOf('.'));
      },

      prepareToDelete(file) {
          this.deletingFile = file;
      },

      cancelDeleting() {
          this.deletingFile = {};
      },

      async deleteFile() {
        try {
          await axios.delete('api/files/delete/' + this.deletingFile.id)
          this.showNotification('Файл успешно удален!', true);
        } catch(error) {
          this.errors = error.response.data.errors;
          this.showNotification('Что-то пошло не так! Пожалуйста, попробуйте позже.', false);
        } finally {
          this.fetchFile(this.files.current_page, this.activeTab);
          this.cancelDeleting();
        } 
      },

      editFile(file) {
        this.editingFile = Object.assign({}, file);
      },

      async endEditing(file) {
        this.editingFile = {};

        if (file.name.trim() === '') {
          alert('Имя файла не может быть пустым!');
          this.fetchFile(1, this.activeTab);
        } else {
          let formData = new FormData();
          formData.append('name', file.name);
          formData.append('type', file.type);
          formData.append('extension', file.extension);

          try {
            const { data } = await axios.post('api/files/edit/' + file.id, formData)
          
            if (data === true) {
              this.showNotification('Имя файла успешно изменено!', true);
              this.fetchFile(this.files.current_page, this.activeTab);
            }
          } catch(error) {
            this.errors = error.response.data.errors;
            this.showNotification(error.response.data.message, false);
          }
        }
      },

      showNotification(text, success) {
        let strErrors = '';
        for (let errorType in this.errors) {
          for (let error of this.errors[errorType]) {
            strErrors += error + '\n';
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
          this.fileName = '';
          this.attachment = '';
          this.$refs.file.value = '';
      },

      clearErrors() {
          this.errors = {};
      }
    }

  } 

</script>

<style lang="scss" scoped>

[v-cloak] {
  display: none;
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

.columns {
  display: flex;
  flex-wrap: wrap;
  margin-left: -10px;
  margin-right: -10px;
  .column {
    margin: 0 10px;
    margin-bottom: 20px;
    &.image {
      width: calc(100% / 4 - 20px);
    }
    &.document {
      width: calc(100% / 6 - 20px);
    }
  }
}

.card {
  display: flex;
  flex-direction: column;
  height: 100%;
  border: 1px solid #f1f1f1;
  border-radius: 3px;
  &-image {
    position: relative;
    .delete {
      &-file {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 21px;
        height: 21px;
        background-color: rgba(#000, .3);
        border: none;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        &:before {
          content: '\2716';
          color: #fff;
          font-size: 10px;
          position: absolute;
          top: 4px;
          right: 6.5px;
        }
      }
    }
    .image {
      &-bg {
        width: 100%;
        height: 220px;
        background: #fff center center no-repeat;
        background-size: cover;
      }
      img {
        display: block;
        width: 100%;
        height: auto;
      }
    }
  }
  &-content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    padding: 10px;
    p {
      flex-grow: 1;
    }
  }
}

.download-file {
  display: inline-block;
  padding: 10px;
  padding-bottom: 0;
}

.tabs-details {
  padding: 10px;
  .columns {
    position: relative;
    min-height: 300px;
    .is-empty {
      margin: 0 auto;
    }
  }
}

.pagination {
  margin: 0;
}

/*==========  Desktop First Method  ==========*/

/* Large Devices, Wide Screens */
@media only screen and (max-width : 1200px) {
  .columns {
    .column {
      &.image {
        width: calc(100% / 2 - 20px);
      }
      &.document {
        width: calc(100% / 4 - 20px);
      }
    }
  }
}


/* Medium Devices, Desktops */
@media only screen and (max-width : 992px) {
  .columns {
    .column {
      &.image {
        width: calc(100% / 2 - 20px);
      }
      &.document {
        width: calc(100% / 3 - 20px);
      }
    }
  }
}

</style>