<template>
  <div class="main-page">
    <h4>Управление пользователями</h4>
    <div class="row flex-row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange">
          <div class="small-box-body">
            <div class="inner">
              <h3>
                <i class="fa fa-user-plus"></i> Добавить пользователя
              </h3>

              <p>Добавить нового ользователя</p>
            </div>
            <!-- <div class="icon">
                            <i class="fa fa-user"></i>
            </div>-->
          </div>
          <a
            href="#"
            class="small-box-footer text-uppercase"
            data-toggle="modal"
            data-target="#add-user"
          >
            Перейти
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-teal">
          <div class="small-box-body">
            <div class="inner">
              <h3>
                <i class="fa fa-user-secret"></i> Сотрудники
              </h3>

              <p>Измени свои данные</p>
            </div>
            <!-- <div class="icon">
                            <i class="fa fa-user"></i>
            </div>-->
          </div>
          <router-link class="small-box-footer text-uppercase" :to="{ name: 'admin.staffs' }">
            Перейти
            <i class="fa fa-arrow-circle-right"></i>
          </router-link>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="small-box-body">
            <div class="inner">
              <h3>
                <i class="fa fa-users"></i> Студенты
              </h3>

              <p>Измени свои данные</p>
            </div>
            <!-- <div class="icon">
                            <i class="fa fa-user"></i>
            </div>-->
          </div>
          <router-link class="small-box-footer text-uppercase" :to="{ name: 'admin.students' }">
            Перейти
            <i class="fa fa-arrow-circle-right"></i>
          </router-link>
        </div>
      </div>
    </div>
    <h4>Управление данными</h4>
    <div class="row flex-row">
      <div class="col-lg-3 col-xs-6">
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
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
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
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
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
  </div>
</template>

<script>
export default {
  middleware: ["auth", "admin"],

  name: "primary",

  metaInfo() {
    return {
      title: "Панель администратора"
    };
  }
};
</script>

<style lang="scss" scoped></style>

