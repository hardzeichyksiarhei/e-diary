<template>
  <div class="control-sidebar-wrapper">
      <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-theme-options-tab" data-toggle="tab"><i class="fa fa-paint-brush"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Theme options tab content -->
        <div class="tab-pane active" id="control-sidebar-theme-options-tab">
					<h3 class="control-sidebar-heading">Параметры макета</h3>
					<div class="form-group">
						<label class="control-sidebar-subheading">
							<input id="topLineFixedChange" type="checkbox" class="pull-right" @click="changeTopLineFixed"> Фикс. верхнее меню
						</label>
					</div>
					<div class="form-group">
						<label class="control-sidebar-subheading">
							<input id="sideBarCollapseChange" type="checkbox" class="pull-right" @click="changeSideBarCollapse"> Состояние бок. панели
						</label>
						<p>Переключить состояние левой боковой панели (открыть или свернуть)</p>
					</div>
					<h3 class="control-sidebar-heading">Цветовые схемы</h3>
					<ul class="list-unstyled clearfix">
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-blue')">
											<div>
													<span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
													<span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Blue</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-black')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span>
													<span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Black</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-purple')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-purple"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Purple</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-green')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-green"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Green</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-red')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-red"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Red</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-yellow')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-yellow"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Yellow</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-blue-light')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-light-blue"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Blue Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-black-light')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
													<span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Black Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-purple-light')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-purple"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Purple Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-green-light')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-green"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Green Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-red-light')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-red"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Green Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
									<a style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover" @click.prevent="changeSkin('skin-yellow-light')">
											<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
													<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
													<span style="display:block; width: 80%; float: left; height: 7px;" class="bg-yellow"></span>
											</div>
											<div>
													<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
													<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
											</div>
									</a>
									<p class="text-center no-margin">Yellow Light</p>
							</li>
					</ul>
        </div>
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">Общие настройки</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Report panel usage
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Some information about this general settings option
              </p>
            </div>
            <!-- /.form-group -->
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { Storage } from "../mixins/storage"

export default {
  mixins: [ Storage ],

  name: 'control-sidebar',

  data () {
    return {
      mySkins: [
        'skin-blue',
        'skin-black',
        'skin-red',
        'skin-yellow',
        'skin-purple',
        'skin-green',
        'skin-blue-light',
        'skin-black-light',
        'skin-red-light',
        'skin-yellow-light',
        'skin-purple-light',
        'skin-green-light'
      ]
    }
  },

  computed: {
    ...mapGetters({
      leftMenuInstance: 'app/leftMenuInstance'
    })
  },

  mounted () {
    /* ControlSidebar()
    * ===============
    * Toggles the state of the control sidebar
    *
    * @Usage: $('#control-sidebar-trigger').controlSidebar(options)
    *         or add [data-toggle="control-sidebar"] to the trigger
    *         Pass any option as data-option="value"
    */
    +(function ($) {
      'use strict'

      var DataKey = 'lte.controlsidebar'

      var Default = {
        slide: true
      }

      var Selector = {
        sidebar: '.control-sidebar',
        data: '[data-toggle="control-sidebar"]',
        open: '.control-sidebar-open',
        bg: '.control-sidebar-bg',
        wrapper: '.wrapper',
        content: '.content-wrapper',
        boxed: '.layout-boxed'
      }

      var ClassName = {
        open: 'control-sidebar-open',
        fixed: 'fixed'
      }

      var Event = {
        collapsed: 'collapsed.controlsidebar',
        expanded: 'expanded.controlsidebar'
      }

      // ControlSidebar Class Definition
      // ===============================
      var ControlSidebar = function (element, options) {
        this.element = element
        this.options = options
        this.hasBindedResize = false

        this.init()
      }

      ControlSidebar.prototype.init = function () {
        // Add click listener if the element hasn't been
        // initialized using the data API
        if (!$(this.element).is(Selector.data)) {
          $(this).on('click', this.toggle)
        }

        this.fix()
        $(window).resize(
          function () {
            this.fix()
          }.bind(this)
        )
      }

      ControlSidebar.prototype.toggle = function (event) {
        if (event) event.preventDefault()

        this.fix()

        if (
          !$(Selector.sidebar).is(Selector.open) &&
                    !$('body').is(Selector.open)
        ) {
          this.expand()
        } else {
          this.collapse()
        }
      }

      ControlSidebar.prototype.expand = function () {
        if (!this.options.slide) {
          $('body').addClass(ClassName.open)
        } else {
          $(Selector.sidebar).addClass(ClassName.open)
        }

        $(this.element).trigger($.Event(Event.expanded))
      }

      ControlSidebar.prototype.collapse = function () {
        $('body, ' + Selector.sidebar).removeClass(ClassName.open)
        $(this.element).trigger($.Event(Event.collapsed))
      }

      ControlSidebar.prototype.fix = function () {
        if ($('body').is(Selector.boxed)) {
          this._fixForBoxed($(Selector.bg))
        }
      }

      // Private

      ControlSidebar.prototype._fixForBoxed = function (bg) {
        bg.css({
          position: 'absolute',
          height: $(Selector.wrapper).height()
        })
      }

      // Plugin Definition
      // =================
      function Plugin (option) {
        return this.each(function () {
          var $this = $(this)
          var data = $this.data(DataKey)

          if (!data) {
            var options = $.extend(
              {},
              Default,
              $this.data(),
              typeof option === 'object' && option
            )
            $this.data(DataKey, (data = new ControlSidebar($this, options)))
          }

          if (typeof option === 'string') data.toggle()
        })
      }

      var old = $.fn.controlSidebar

      $.fn.controlSidebar = Plugin
      $.fn.controlSidebar.Constructor = ControlSidebar

      // No Conflict Mode
      // ================
      $.fn.controlSidebar.noConflict = function () {
        $.fn.controlSidebar = old
        return this
      }

      // ControlSidebar Data API
      // =======================
      $(document).on('click', Selector.data, function (event) {
        if (event) event.preventDefault()
        Plugin.call($(this), 'toggle')
      })
    })(jQuery)

    this.setup()
  },

  destroyed () {
    $(document).off('click', '[data-toggle="control-sidebar"]')
    $('[data-toggle="control-sidebar"]').removeData('lte.controlsidebar')
  },

  methods: {
    changeSkin (cls) {
      const body = document.body
      for (const skin of this.mySkins) {
        body.classList.remove(skin)
      }

      body.classList.add(cls)
      this.storageSave('skin', cls)
      return false
    },

    changeTopLineFixed (e) {
      document.body.classList.toggle('top-line-fixed')
      if (e.currentTarget.checked) {
        this.storageSave('top-line-fixed', true)
      } else {
        this.storageSave('top-line-fixed', false)
      }
    },

    changeSideBarCollapse (e) {
      this.leftMenuInstance.toggle();
      if (e.currentTarget.checked) {
        this.storageSave('sidebar-collapsed', true)
      } else {
        this.storageSave('sidebar-collapsed', false)
      }
    },

    setup () {
      const body = document.body
      const skin = this.storageGet('skin')
      const topLineFixed = this.storageGet('top-line-fixed')
      const sideBarCollapsed = this.storageGet('sidebar-collapsed')

      if (skin && $.inArray(skin, this.mySkins)) this.changeSkin(skin)

      if (topLineFixed === 'true') {
        body.classList.add('top-line-fixed')
        document.getElementById('topLineFixedChange').checked = true
      }

      if (sideBarCollapsed === 'true') {
        document.getElementById('sideBarCollapseChange').checked = true
      }
    }
  }
}
</script>
