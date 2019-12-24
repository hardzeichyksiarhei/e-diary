<template>
  <div class="main-page">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <image-staff-box v-if="check && user.role !== 'student'" :user="user"/>
          <image-student-box v-if="check && user.role === 'student'" :user="user"/>

          <!-- About Me Box -->
          <about-me-staff-box v-if="check && user.role !== 'student'" :user="user"/>
          <about-me-student-box v-if="check && user.role === 'student'" :user="user"/>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <!-- <li class="active"><a href="#info" data-toggle="tab">Общее</a></li> -->
              <li class="active"><a href="#auth-info" data-toggle="tab">Учетная информация</a></li>
              <li><a href="#edit-profile" data-toggle="tab">Доп. информация</a></li>
            </ul>
            <div class="tab-content">
              <!-- <div class="active tab-pane" id="info"></div> -->
              <!-- /.tab-pane -->

              <div class="active tab-pane" id="auth-info">
                <div class="alert bg-light-blue mb-3" role="alert">
                  <h4 class="alert-heading">Изменение аватара</h4>
                  <p>Граватар — это картинка, которая следует за вами от сайта к сайту, появляясь при отправке комментария или записи в блог. Аватары помогают узнавать вас в блогах и на форумах, так почему бы не использовать их везде?</p>
                  <hr>
                  <p class="mb-0">Для изменения аватара, перейдите по ссылке: <a href="https://ru.gravatar.com" target="_blank">Gravavatar.com</a></p>
                </div>
                <h4 class="pb-3 border-bottom">Учетная информация</h4>
                <change-auth-data/>
                <h4 class="pb-3 mt-4 border-bottom">Изменить пароль</h4>
                <change-password/>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="edit-profile">
                <template v-if="check">
                  <update-student-profile-data v-if="user.role === 'student'"/>
                  <update-staff-profile-data v-else/>
                </template>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    import ImageStaffBox from '../../components/profile/ImageStaffBox'
    import ImageStudentBox from '../../components/profile/ImageStudentBox'
    import AboutMeStaffBox from '../../components/profile/AboutMeStaffBox'
    import AboutMeStudentBox from '../../components/profile/AboutMeStudentBox'

    import ChangeAuthData from "../../components/profile/ChangeAuthData";
    import ChangePassword from "../../components/profile/ChangePassword";
    import UpdateStudentProfileData from "../../components/profile/UpdateStudentProfileData";
    import UpdateStaffProfileData from "../../components/profile/UpdateStaffProfileData";

    export default {
        middleware: ['auth'],

        name: 'index',

        metaInfo() {
          return { title: 'Профайл' }
        },

        components: {
            ImageStaffBox,
            ImageStudentBox,
            AboutMeStaffBox,
            AboutMeStudentBox,

            ChangeAuthData,
            ChangePassword,
            UpdateStudentProfileData,
            UpdateStaffProfileData
        },

        computed: mapGetters({
            check: 'auth/check',
            user: 'auth/user'
        })
    };
</script>

<style lang="scss" scoped></style>

