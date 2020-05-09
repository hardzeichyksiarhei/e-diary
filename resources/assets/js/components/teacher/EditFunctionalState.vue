<template>
  <modal modal-id="edit-functional-state" modal-size="lg" :show-handler="showEditFunctionalState" :hidden-handler="cancelEditFunctionalState">
    <template v-slot:title>Физическое развитие и функциональное состояние (ФР и ФС)</template>
    <template v-slot:body>
      <functional-state-initial-data v-if="userId !== -1" :user-id="userId" :show-title="false"/>
    </template>
    <template v-slot:footer>
      <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
    </template>>
  </modal>
</template>

<script>
  import axios from "axios";

  import Modal from "~/components/Modal";
  import FunctionalStateInitialData from '~/components/FunctionalState/FunctionalStateInitialData'

  export default {
    name: "EditFunctionalState",

    props: ['userId'],

    components: {
      Modal,
      FunctionalStateInitialData
    },

    methods: {
      showEditFunctionalState() {},

      cancelEditFunctionalState() {
        this.$emit("cancel-functional-state");
      },
    }
  }
</script>

<style scoped>

</style>
