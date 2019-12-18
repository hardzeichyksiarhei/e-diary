<template>
	<div class="compose-page">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Написать новое сообщение</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="form-group">
					<label for="mailbox-recipients">Имя или E-mail получателя</label>
					<select2 id="mailbox-recipients" class="form-control select2"
						v-model="message.receiver_ids"
						:url="'/api/user/search'"
						:templateResult="mailboxRecipients"
						multiple="multiple"
					>
					</select2>
				</div>
				<div class="form-group">
					<label for="student">Тема сообщения:</label>
					<input class="form-control" placeholder="Введите тему сообщения:" v-model="message.subject">
				</div>
				<div class="form-group mb-0">
					<editor v-model="message.text" :init="{
						skin_url: '/css/skins/custom',
						height: 300,
						menubar: false,
						plugins: [ 'wordcount', 'lists' ],
						toolbar: 'undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
						branding: false
					}"></editor>
				</div>
        <div class="attachment-file">
          <div class="attachment-file-field">
            <div class="attachment-file-name">
              <input class="form-control" name="name" placeholder="File name" v-model="message.fileName">
            </div>
            <div class="file">
              <label class="file-label">
                <input class="file-input" type="file" ref="file" name="file" @change="addFile()">
                <span class="file-cta btn btn-success"><i class="fa fa-upload"></i>&nbsp;Добавить файл</span>
              </label>
            </div>
          </div>
        </div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-primary" @click.prevent="sendMessage">
					<i class="fa fa-envelope-o"></i>&nbsp;Отправить
				</button>
				<button type="button" class="btn btn-default" @click.prevent="reset"><i class="fa fa-times"></i>&nbsp;Отмена</button>
			</div>
			<!-- /.box-footer -->
		</div>
	</div>
</template>

<script>
// Import TinyMCE
import tinymce from 'tinymce/tinymce'

// A theme is also required
import 'tinymce/themes/modern/theme'

// Any plugins you want to use has to be imported
import 'tinymce/plugins/paste'
import 'tinymce/plugins/link'
import 'tinymce/plugins/wordcount'
import 'tinymce/plugins/lists'

import Editor from '@tinymce/tinymce-vue'

import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
	data () {
		return {
			listStudents: [],
			message: {
				receiver_ids: [],
				subject: '',
        text: '',
        attachment: '',
        fileName: ''
      },
      formData: {}
		}
	},

  components: { Editor },

	computed: mapGetters({
		user: 'auth/user'
	}),

	methods: {
		mailboxRecipients (item) {
			if (item.loading) {
				return item.text;
			}

			let markup = `
				<div class='select2-mailbox-recipients clearfix'>
					<div class='select2-mailbox-recipients__avatar'><img src='${item.photo_url}' /></div>
					<div class='select2-mailbox-recipients__meta'>
						<span class='select2-mailbox-recipients__name'>${item.name}</span>
						<span class='select2-mailbox-recipients__email'>${item.email}</span>
					</div>
				</div>
			`

			return markup
		},
		async sendMessage () {
			try {
        this.formData = new FormData();
        this.formData.append('receiver_ids', this.message.receiver_ids);
        this.formData.append('subject', this.message.subject);
        this.formData.append('text', this.message.text);
        this.formData.append('name', this.message.fileName);
        this.formData.append('attachment', this.message.attachment);

				await axios.post('/api/messages/send', this.formData, { 
            headers: {
              'Content-Type': 'multipart/form-data'
              } 
            });
				IziToast.success({ message: 'Сообщение отправленно' });
				// Reset form
				this.reset();
			} catch (error) {
				console.log(error)
			}
		},
		reset () {
			// Reset form
			this.message = {
				receiver_ids: [],
				subject: '',
        text: '',
        attachment: '',
        fileName: ''
      };
      this.formData = {};
      this.$refs.file.value = '';
    },
    
    addFile() {
      this.message.attachment = this.$refs.file.files[0];
      let filename = this.message.attachment ? this.message.attachment.name : '';
      this.message.fileName = filename.substring(0, filename.lastIndexOf('.'));
    },
	}
}
</script>

<style lang="scss">
.attachment-file {
  margin-top: 20px;
  &-field {
    display: flex;
    align-items: center;
  }
  &-name {
    flex-grow: 1;
  }
  .file {
    &-label {
      margin-bottom: 0;
      margin-left: 10px;
    }
    &-input {
      display: none;
    }
  }
}
.select2-mailbox-recipients {
	display: flex;
	&__avatar img {
		width: 40px;
		margin-right: 10px;
	}
	&__name {
		color: #343a40;
		font-size: 16px;
	}
	&__email {
		font-size: 12px;
	}
	&__meta {
		flex: 1;
		display: flex;
		flex-direction: column;
	}
}
</style>


