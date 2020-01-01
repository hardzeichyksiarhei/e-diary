<template>
  <div class="share-files-page">
    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="fa fa-docs"></i>
        <h3 class="box-title">Доступные документы</h3>
      </div>
      <div class="box-body">
        <template v-if="files.total">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-no-hover">
              <thead>
                <tr>
                  <th id="name">Название</th>
                  <th id="share-user">Доступ предоставил</th>
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
                      <a
                        title="Save"
                        :href="domainURL + '/documents/' + file.user.email.split('@')[0] + '_' + file.user.id + '/' + file.type + '/' + file.tmp_name + '.' + file.extension"
                        :download="file.name"
                        target="_blank"
                      >
                        {{ file.name }}.{{ file.extension }}
                      </a>
                    </div>
                  </td>
                  <td>{{ file.user.name }}</td>
                  <td>{{ file.created_at }}</td>
                  <td class="options">
                    <div class="btn-group">
                      <a
                        class="btn btn-sm btn-success w-100"
                        title="Save"
                        :href="domainURL + '/documents/' + file.user.email.split('@')[0] + '_' + file.user.id + '/' + file.type + '/' + file.tmp_name + '.' + file.extension"
                        :download="file.name"
                        target="_blank"
                      >
                        <i class="fa fa-save fa-fw"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination :data="files" :limit="3" @pagination-change-page="fetchShareFiles" :show-disabled="true">
            <span slot="prev-nav"><i class="fa fa-angle-left"></i></span>
            <span slot="next-nav"><i class="fa fa-angle-right"></i></span>
          </pagination>
        </template>
        <div class="is-empty" v-else v-cloak>
          <img :src="domainURL + '/images/not_found.png'" alt="Folder empty" id="folder_empty">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import { domainURL } from "~/config";

export default {
  middleware: ["auth", "student"],

  name: "share-files",

  data() {
    return {
      domainURL,
      files: {}
    };
  },

  computed: {
    ...mapGetters({
      user: "auth/user"
    })
  },

  mounted() {
    this.fetchShareFiles(1);
  },

  methods: {
    async fetchShareFiles(page = 1) {
      try {
        this.$store.dispatch("loading/changeLoading");
        const { data } = await axios.get("/api/files/share?page=" + page);
        this.files = data;
        console.log(this.files);
      } catch (error) {
        console.error(error);
      } finally {
        this.$store.dispatch("loading/changeLoading");
      }
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