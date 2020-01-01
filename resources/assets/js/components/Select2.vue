<template>
  <select>
      <slot></slot>
  </select>
</template>

<script>
export default {
  name: 'select2',
  props: {
    options: {
      type: Array,
      default () {
        return []
      }
    },
    settings: {
      type: Object,
      default () {
        return {
          width: '100%'
        }
      }
    },
    value: {
      default: null
    },
    url: {
      type: String,
      default: ''
    },
    templateResult: {
      type: Function,
      default: (item) => item.text || item.name
    },
    templateSelection: {
      type: Function,
      default: (item) => item.text || item.name
    }
  },
  data () {
    return {
      ajaxOptions: {
        url: this.url,
        dataType: 'json',
        delay: 250,
        tags: true,
        data (params) {
          return {
            term: params.term, // search term
            page: params.page || 1
          }
        },
        processResults (data, params) {
          params.page = params.page || 1
          return {
            results: data.data,
            pagination: {
              more: params.page !== data.last_page
            }
          }
        },
        cache: true
      }
    }
  },
  mounted () {
    const vm = this
    const selectAttrAjax = {
      ajax: this.ajaxOptions
    }
    const selectAttrData = {
      data: this.options
    }
    const selectAttr = this.url ? selectAttrAjax : selectAttrData
    $(this.$el)
    // init select2
      .select2({
        ...selectAttr,
        ...this.settings,
        escapeMarkup (markup) { return markup },
        templateResult: this.templateResult,
        templateSelection: this.templateSelection
      })
      .val(this.value)
      .trigger('change')
    // emit event on change.
      .on('change', function () {
        vm.$emit('input', $(this).val())
      })
  },
  watch: {
    url (value) {
      this.ajaxOptions.url = this.url
      $(this.$el).select2({
        ...this.settings,
        ajax: this.ajaxOptions,
        width: '100%'
      })
    },
    value: function (value) {
      if ([...value].sort().join(',') !== [...$(this.$el).val()].sort().join(',')) { $(this.$el).val(value).trigger('change') }
    },
    options: function (options) {
      // update options
      $(this.$el).select2({
        ...this.settings,
        data: options,
        width: '100%'
      })
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  },
  methods: {
  /* formatRepo (repo) {
      if (repo.loading) {
        return repo.text;
      }

      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='" + repo.data.photo_url + "' /></div>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.data.name + "</div>";

      return markup;
    },
    formatRepoSelection (repo) {
      return repo.data.name || repo.data.text;
    } */
  }
}
</script>

<style lang="less">
  .select2-container--default.select2-container--open {
    z-index: 99999;
  }
</style>


