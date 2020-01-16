<template>
  <div class="home-wrapper">
    <!-- Small boxes (Stat box) -->
    <h4>Общий функционал</h4>
    <div class="row flex-row">
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="small-box-body">
            <div class="inner">
              <h3>
                <i class="fa fa-user"></i>Профайл
              </h3>

              <p>Измени свои данные</p>
            </div>
            <!-- <div class="icon">
                            <i class="fa fa-user"></i>
            </div>-->
          </div>
          <router-link class="small-box-footer text-uppercase" :to="{ name: 'profile' }">
            Перейти
            <i class="fa fa-arrow-circle-right"></i>
          </router-link>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="small-box-body">
            <div class="inner">
              <h3>
                <i class="fa fa-sign-out"></i>Выход
              </h3>

              <p>Выход из приложения</p>
            </div>
            <!-- <div class="icon">
                            <i class="fa fa-sign-out"></i>
            </div>-->
          </div>
          <a
            href="#"
            class="small-box-footer text-uppercase"
            data-toggle="modal"
            data-target="#logout"
          >
            Выйти
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <template v-if="check && user.role === 'admin'">
      <h4>Функционал администратора</h4>
      <h5>Управление пользователями</h5>
      <div class="row flex-row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-user-secret"></i>Преподаватели
                </h3>

                <p>Управление сотрудниками</p>
              </div>
              <!-- <div class="icon">
                                <i class="fa fa-user-secret"></i>
              </div>-->
            </div>
            <router-link class="small-box-footer text-uppercase" :to="{ name: 'admin.staffs' }">
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-users"></i>Студенты
                </h3>

                <p>Управление студентами</p>
              </div>
              <!-- <div class="icon">
                                <i class="fa fa-users"></i>
              </div>-->
            </div>
            <router-link class="small-box-footer text-uppercase" :to="{ name: 'admin.students' }">
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-users"></i>Массовое добавление
                </h3>

                <p>Массовое добавление пользователей</p>
              </div>
              <!-- <div class="icon">
                    <i class="fa fa-users"></i>
              </div>-->
            </div>
            <router-link class="small-box-footer text-uppercase" :to="{ name: 'admin.bulk-add' }">
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <h5>Управление данными</h5>
      <div class="row flex-row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-mortar-board"></i> Факультеты
                </h3>

                <p>Измени свои данные</p>
              </div>
              <!-- <div class="icon">
                            <i class="fa fa-user"></i>
              </div>-->
            </div>
            <router-link class="small-box-footer text-uppercase" :to="{ name: 'admin.faculties' }">
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-stethoscope"></i>Мед. группы здоровья
                </h3>

                <p>Измени свои данные</p>
              </div>
              <!-- <div class="icon">
                            <i class="fa fa-user"></i>
              </div>-->
            </div>
            <router-link
              class="small-box-footer text-uppercase"
              :to="{ name: 'admin.health-groups' }"
            >
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-stethoscope"></i> Группы заболевания
                </h3>

                <p>Измени свои данные</p>
              </div>
              <!-- <div class="icon">
                            <i class="fa fa-user"></i>
              </div>-->
            </div>
            <router-link
              class="small-box-footer text-uppercase"
              :to="{ name: 'admin.disease-groups' }"
            >
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </template>
    <template v-if="check && user.role === 'student'">
      <h4>Функционал студента</h4>
      <div class="row flex-row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-database"></i>Измерения и Показатели
                </h3>

                <p>Заносится информация фактических измерений антропометрических показаний</p>
              </div>
              <!-- <div class="icon">
                                <i class="fa fa-database"></i>
              </div>-->
            </div>
            <router-link class="small-box-footer text-uppercase" :to="{ name: 'indicators' }">
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-area-chart"></i>Статистическая обработка
                </h3>

                <p>Предусматривает статистическую обработку и просмотр данных</p>
              </div>
              <!-- <div class="icon">
                                <i class="fa fa-area-chart"></i>
              </div>-->
            </div>
            <router-link
              class="small-box-footer text-uppercase"
              :to="{ name: 'statistics.primary' }"
            >
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-files-o"></i>Доступные файлы
                </h3>

                <p>Файлы доступные лля просмотра</p>
              </div>
              <!-- <div class="icon">
                    <i class="fa fa-area-chart"></i>
              </div>-->
            </div>
            <router-link
              class="small-box-footer text-uppercase"
              :to="{ name: 'files.share' }"
            >
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </template>
    <template v-if="check && user.role === 'teacher'">
      <h4>Функционал преподавателя</h4>
      <div class="row flex-row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="small-box-body">
              <div class="inner">
                <h3>
                  <i class="fa fa-users"></i>Cтуденты
                </h3>

                <p>Cтуденты</p>
              </div>
              <!-- <div class="icon">
                                <i class="fa fa-database"></i>
              </div>-->
            </div>
            <router-link class="small-box-footer text-uppercase" :to="{ name: 'teacher.students' }">
              Перейти
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </template>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  middleware: "auth",

  metaInfo() {
    return { title: "Панель управления" };
  },

  computed: {
    ...mapGetters({
      user: "auth/user",
      check: "auth/check",
      totalNotifications: "messages/totalNotifications"
    })
  },

  created() {
    if (!this.user.profile) {
      IziToast.info({
        title: `Привет, ${this.user.name}`,
        overlay: true,
        message:
          '<p style="margin: 10px 0;">Перед тем как приступить к работе, заполните персональные данные.</p>',
        position: "center",
        progressBarColor: "#fff",
        zindex: 9999,
        buttons: [
          [
            "<button>Перейти</button>",
            (instance, toast) => {
              this.$router.push("profile");
              instance.hide(
                {
                  transitionOut: "fadeOutUp"
                },
                toast,
                "button"
              );
            }
          ]
        ]
      });
    }
  },

  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");

      // Redirect to login.
      this.$router.push({ name: "login" });
    }
  }
};
</script>

<style lang="scss" scoped></style>
