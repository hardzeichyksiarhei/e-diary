<template>
  <div class="modal fade" :id="modalId" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" :class="`modal-${modalSize}`" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">
            <slot name="title"/>
          </h4>
        </div>
        <div class="modal-body">
          <slot name="body"/>
        </div>
        <div class="modal-footer">
          <slot name="footer"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'modal',

    props: {
      modalId: String,
      modalSize: {
        type: String,
        default: 'md'
      },
      hiddenHandler: Function,
      showHandler: Function
    },

    mounted() {
      if (this.showHandler) {
        $('#' + this.modalId).on('show.bs.modal', this.showHandler);
      }
      if (this.hiddenHandler) {
        $('#' + this.modalId).on('hidden.bs.modal', this.hiddenHandler);
      }
    }
  }
</script>
