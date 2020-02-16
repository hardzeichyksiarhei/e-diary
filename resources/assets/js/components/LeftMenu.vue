<template>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div v-if="check" class="pull-left image">
          <img :src="user.photo_url" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
          <p>{{ user | full_name_short }}</p>
          <!-- Status -->
          <a href="#">
            <i class="fa fa-circle text-success"></i> Online
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <router-link tag="li" title="Главная" :to="{ name: 'welcome' }">
          <a>
            <i class="fa fa-home"></i>
            <span>Главная</span>
          </a>
        </router-link>
        <template v-if="check && user.role === 'teacher'">
          <li class="header">Преподаватель</li>
          <router-link
            tag="li"
            title="Cтуденты"
            :to="{ name: 'teacher.students' }"
            active-class="active"
          >
            <a>
              <i class="fa fa-users"></i>
              <span>Cтуденты</span>
            </a>
          </router-link>
          <router-link tag="li" title="Документы" :to="{ name: 'files' }" active-class="active">
            <a>
              <i class="fa fa-files-o"></i>
              <span>Документы</span>
            </a>
          </router-link>
        </template>
        <template v-if="check && user.role === 'admin'">
          <li class="header">Администратор</li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Пользователи</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="#" data-toggle="modal" data-target="#add-user">
                  <i class="fa fa-circle-o"></i>Добавить пользователя
                </a>
              </li>
              <router-link tag="li" :to="{ name: 'admin.staffs' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>Сотрудники
                </a>
              </router-link>
              <router-link tag="li" :to="{ name: 'admin.students' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>Студенты
                </a>
              </router-link>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-database"></i>
              <span>Данные</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <router-link tag="li" :to="{ name: 'admin.faculties' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>Факультеты
                </a>
              </router-link>
              <router-link tag="li" :to="{ name: 'admin.health-groups' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>Мед. группы здоровья
                </a>
              </router-link>
              <router-link tag="li" :to="{ name: 'admin.disease-groups' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>Группы заболевания
                </a>
              </router-link>
            </ul>
          </li>
          <router-link tag="li" title="Документы" :to="{ name: 'files' }" active-class="active">
            <a>
              <i class="fa fa-files-o"></i>
              <span>Документы</span>
            </a>
          </router-link>
        </template>
        <template v-if="check && user.role === 'student'">
          <li class="header">Студент</li>
          <router-link
            tag="li"
            title="Измерения и Показатели"
            :to="{ name: 'indicators' }"
            active-class="active"
          >
            <a>
              <i class="fa fa-database"></i>
              <span>Измерения и Показатели</span>
            </a>
          </router-link>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-area-chart"></i>
              <span>Статистика</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <router-link tag="li" :to="{ name: 'statistics.functional-state' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>Функциональное развитие и состояние (ФР и ФС)
                </a>
              </router-link>
              <router-link tag="li" :to="{ name: 'statistics.physical-fitness' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>Физическая подготовленность (ФП)
                </a>
              </router-link>
              <router-link tag="li" :to="{ name: 'statistics.common-assessment' }" active-class="active">
                <a>
                  <i class="fa fa-circle-o"></i>бщая оценка и уровень ФР, ФС и ФП
                </a>
              </router-link>
            </ul>
          </li>
          <router-link
            tag="li"
            title="Доступные файлы"
            :to="{ name: 'files.share' }"
            active-class="active"
          >
            <a>
              <i class="fa fa-files-o"></i>
              <span>Доступные файлы</span>
            </a>
          </router-link>
        </template>
        <li class="header">Общее</li>
        <router-link
          tag="li"
          title="Панель управления"
          :to="{ name: 'dashboard' }"
          active-class="active"
        >
          <a>
            <i class="fa fa-dashboard"></i>
            <span>Панель управления</span>
          </a>
        </router-link>
        <router-link tag="li" title="Профайл" :to="{ name: 'profile' }" active-class="active">
          <a>
            <i class="fa fa-user"></i>
            <span>Профайл</span>
          </a>
        </router-link>
        <li>
          <a href="#" data-toggle="modal" data-target="#logout">
            <i class="fa fa-sign-out"></i>
            <span>Выйти</span>
          </a> 
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
import { mapGetters } from "vuex";
import { Storage } from "../mixins/storage";
import { FullNameShort } from "../mixins/name";
import LeftMenu from '../plugins/left-menu';


export default {
  mixins: [ Storage, FullNameShort ],

  data: () => ({
    appName: window.config.appName,
  }),

  computed: {
    ...mapGetters({
      user: "auth/user",
      check: "auth/check"
    })
  },

  mounted: function() {
      new LeftMenu({
        isAnimation: false,
        isCollapsed: this.storageGet('sidebar-collapsed') === 'true',
        callbacks: {
          init: (instance) => {
            this.$store.commit('app/SET_LEFT_MENU_INSTANCE', instance);
            instance.options.isCollapsed ? this.$store.commit('app/LEFT_MENU_CLOSE') : this.$store.commit('app/LEFT_MENU_OPEN');
          },
          open: () => { this.$store.commit('app/LEFT_MENU_OPEN'); },
          close: () => { this.$store.commit('app/LEFT_MENU_CLOSE'); }
        }
      })
    
      /* Tree */
      +(function($) {
        "use strict";

        var DataKey = "lte.tree";

        var Default = {
          animationSpeed: 100,
          accordion: true,
          followLink: false,
          trigger: ".treeview a"
        };

        var Selector = {
          tree: ".tree",
          treeview: ".treeview",
          treeviewMenu: ".treeview-menu",
          open: ".menu-open, .active",
          li: "li",
          data: '[data-widget="tree"]',
          active: ".active"
        };

        var ClassName = {
          open: "menu-open",
          tree: "tree"
        };

        var Event = {
          collapsed: "collapsed.tree",
          expanded: "expanded.tree"
        };

        // Tree Class Definition
        // =====================
        var Tree = function(element, options) {
          this.element = element;
          this.options = options;

          $(this.element).addClass(ClassName.tree);

          $(Selector.treeview + Selector.active, this.element).addClass(
            ClassName.open
          );

          this._setUpListeners();
        };

        Tree.prototype.toggle = function(link, event) {
          var treeviewMenu = link.next(Selector.treeviewMenu);
          var parentLi = link.parent();
          var isOpen = parentLi.hasClass(ClassName.open);

          if (!parentLi.is(Selector.treeview)) {
            return;
          }

          if (!this.options.followLink || link.attr("href") === "#") {
            event.preventDefault();
          }

          if (isOpen) {
            this.collapse(treeviewMenu, parentLi);
          } else {
            this.expand(treeviewMenu, parentLi);
          }
        };

        Tree.prototype.expand = function(tree, parent) {
          var expandedEvent = $.Event(Event.expanded);

          if (this.options.accordion) {
            var openMenuLi = parent.siblings(Selector.open);
            var openTree = openMenuLi.children(Selector.treeviewMenu);
            this.collapse(openTree, openMenuLi);
          }

          parent.addClass(ClassName.open);
          tree.slideDown(
            this.options.animationSpeed,
            function() {
              $(this.element).trigger(expandedEvent);
            }.bind(this)
          );
        };

        Tree.prototype.collapse = function(tree, parentLi) {
          var collapsedEvent = $.Event(Event.collapsed);

          tree.find(Selector.open).removeClass(ClassName.open);
          parentLi.removeClass(ClassName.open);
          tree.slideUp(
            this.options.animationSpeed,
            function() {
              tree.find(Selector.open + " > " + Selector.treeview).slideUp();
              $(this.element).trigger(collapsedEvent);
            }.bind(this)
          );
        };

        // Private

        Tree.prototype._setUpListeners = function() {
          var that = this;

          $(this.element).on("click", this.options.trigger, function(event) {
            that.toggle($(this), event);
          });
        };

        // Plugin Definition
        // =================
        function Plugin(option) {
          return this.each(function() {
            var $this = $(this);
            var data = $this.data(DataKey);

            if (!data) {
              var options = $.extend(
                {},
                Default,
                $this.data(),
                typeof option === "object" && option
              );
              $this.data(DataKey, new Tree($this, options));
            }
          });
        }

        var old = $.fn.tree;

        $.fn.tree = Plugin;
        $.fn.tree.Constructor = Tree;

        // No Conflict Mode
        // ================
        $.fn.tree.noConflict = function() {
          $.fn.tree = old;
          return this;
        };

        // Tree Data API
        // =============
        $(Selector.data).each(function() {
          Plugin.call($(this));
        });
      })(jQuery);
  },

  destroyed() {
    this.$store.commit('app/CLEAR_LEFT_MENU');
    $('[data-widget="tree"]').removeData("lte.tree");
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
