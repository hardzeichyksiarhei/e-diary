<template>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img :src="user.photo_url" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
          <p>{{ full_name_short }}</p>
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
          <li class="header">TEACHER</li>
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
        <!-- <li class="treeview">
							<a href="#"><i class="fa fa-envelope"></i> <span>Сообщения</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<router-link tag="li" :to="{ name: 'messages.compose' }" active-class="active">
									<a><i class="fa fa-inbox"></i>Написать</a>
								</router-link>
								<router-link tag="li" :to="{ name: 'messages.inbox' }" active-class="active">
									<a>
										<i class="fa fa-inbox"></i>Входящие
										<span v-if="totalNotifications" class="pull-right-container">
											<span class="label label-primary pull-right">{{ totalNotifications }}</span>
										</span>
									</a>
								</router-link>
								<router-link tag="li" :to="{ name: 'messages.sent' }" active-class="active">
									<a><i class="fa fa-envelope"></i>Исходящие</a>
								</router-link>
								<router-link tag="li" :to="{ name: 'messages.trash' }" active-class="active">
									<a><i class="fa fa-trash"></i>Корзина</a>
								</router-link>
							</ul>
        </li>-->
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
          <router-link
            tag="li"
            title="Статистическая обработка"
            :to="{ name: 'statistics.primary' }"
            active-class="active"
          >
            <a>
              <i class="fa fa-area-chart"></i>
              <span>Статистическая обработка</span>
            </a>
          </router-link>
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

export default {
  data: () => ({
    appName: window.config.appName
  }),

  computed: {
    ...mapGetters({
      user: "auth/user",
      check: "auth/check",
      // totalNotifications: "messages/totalNotifications"
    }),
    full_name_short() {
      let { first_name, last_name, patronymic_name } = this.user;
      let res = last_name + ' ' + first_name;
      if (patronymic_name.length) {
        res = last_name + ' ' + first_name[0] + '. ' + patronymic_name[0] + '.';
      }
      return res;
    }
  },

  mounted: function() {
    /* PushMenu()
     * ==========
     * Adds the push menu functionality to the sidebar.
     *
     * @usage: $('.btn').pushMenu(options)
     *          or add [data-toggle="push-menu"] to any button
     *          Pass any option as data-option="value"
     */
    +(function($) {
      "use strict";

      var DataKey = "lte.pushmenu";

      var Default = {
        collapseScreenSize: 767,
        expandOnHover: false,
        expandTransitionDelay: 200
      };

      var Selector = {
        collapsed: ".sidebar-collapse",
        open: ".sidebar-open",
        mainSidebar: ".main-sidebar",
        contentWrapper: ".content-wrapper",
        searchInput: ".sidebar-form .form-control",
        button: '[data-toggle="push-menu"]',
        mini: ".sidebar-mini",
        expanded: ".sidebar-expanded-on-hover",
        layoutFixed: ".fixed"
      };

      var ClassName = {
        collapsed: "sidebar-collapse",
        open: "sidebar-open",
        mini: "sidebar-mini",
        expanded: "sidebar-expanded-on-hover",
        expandFeature: "sidebar-mini-expand-feature",
        layoutFixed: "fixed"
      };

      var Event = {
        expanded: "expanded.pushMenu",
        collapsed: "collapsed.pushMenu"
      };

      // PushMenu Class Definition
      // =========================
      var PushMenu = function(options) {
        this.options = options;
        this.init();
      };

      PushMenu.prototype.init = function() {
        if (
          this.options.expandOnHover ||
          $("body").is(Selector.mini + Selector.layoutFixed)
        ) {
          this.expandOnHover();
          $("body").addClass(ClassName.expandFeature);
        }

        $(Selector.contentWrapper).click(
          function() {
            // Enable hide menu when clicking on the content-wrapper on small screens
            if (
              $(window).width() <= this.options.collapseScreenSize &&
              $("body").hasClass(ClassName.open)
            ) {
              this.close();
            }
          }.bind(this)
        );

        // __Fix for android devices
        $(Selector.searchInput).click(function(e) {
          e.stopPropagation();
        });
      };

      PushMenu.prototype.toggle = function() {
        var windowWidth = $(window).width();
        var isOpen = !$("body").hasClass(ClassName.collapsed);

        if (windowWidth <= this.options.collapseScreenSize) {
          isOpen = $("body").hasClass(ClassName.open);
        }

        if (!isOpen) {
          this.open();
        } else {
          this.close();
        }
      };

      PushMenu.prototype.open = function() {
        var windowWidth = $(window).width();

        if (windowWidth > this.options.collapseScreenSize) {
          $("body")
            .removeClass(ClassName.collapsed)
            .trigger($.Event(Event.expanded));
        } else {
          $("body")
            .addClass(ClassName.open)
            .trigger($.Event(Event.expanded));
        }
      };

      PushMenu.prototype.close = function() {
        var windowWidth = $(window).width();
        if (windowWidth > this.options.collapseScreenSize) {
          $("body")
            .addClass(ClassName.collapsed)
            .trigger($.Event(Event.collapsed));
        } else {
          $("body")
            .removeClass(ClassName.open + " " + ClassName.collapsed)
            .trigger($.Event(Event.collapsed));
        }
      };

      PushMenu.prototype.expandOnHover = function() {
        $(Selector.mainSidebar).hover(
          function() {
            if (
              $("body").is(Selector.mini + Selector.collapsed) &&
              $(window).width() > this.options.collapseScreenSize
            ) {
              this.expand();
            }
          }.bind(this),
          function() {
            if ($("body").is(Selector.expanded)) {
              this.collapse();
            }
          }.bind(this)
        );
      };

      PushMenu.prototype.expand = function() {
        setTimeout(function() {
          $("body")
            .removeClass(ClassName.collapsed)
            .addClass(ClassName.expanded);
        }, this.options.expandTransitionDelay);
      };

      PushMenu.prototype.collapse = function() {
        setTimeout(function() {
          $("body")
            .removeClass(ClassName.expanded)
            .addClass(ClassName.collapsed);
        }, this.options.expandTransitionDelay);
      };

      // PushMenu Plugin Definition
      // ==========================
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
            $this.data(DataKey, (data = new PushMenu(options)));
          }

          if (option === "toggle") data.toggle();
        });
      }

      var old = $.fn.pushMenu;

      $.fn.pushMenu = Plugin;
      $.fn.pushMenu.Constructor = PushMenu;

      // No Conflict Mode
      // ================
      $.fn.pushMenu.noConflict = function() {
        $.fn.pushMenu = old;
        return this;
      };

      // Data API
      // ========
      $(document).on("click", Selector.button, function(e) {
        e.preventDefault();
        Plugin.call($(this), "toggle");
      });
      Plugin.call($(Selector.button));
    })(jQuery) +
      /* Tree()
       * ======
       * Converts a nested list into a multilevel
       * tree view menu.
       *
       * @Usage: $('.my-menu').tree(options)
       *         or add [data-widget="tree"] to the ul element
       *         Pass any option as data-option="value"
       */
      (function($) {
        "use strict";

        var DataKey = "lte.tree";

        var Default = {
          animationSpeed: 300,
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
    $(document).off("click", '[data-toggle="push-menu"]');
    $('[data-toggle="push-menu"]').removeData("lte.pushmenu");
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
