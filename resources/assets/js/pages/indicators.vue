<template>
    <div class="data-wrapper">
        <functional-state-initial-data/>
        <physical-fitness-initial-data/>
    </div>
</template>

<script>
import FunctionalStateInitialData from '~/components/FunctionalState/FunctionalStateInitialData'
import PhysicalFitnessInitialData from '~/components/PhysicalFitness/PhysicalFitnessInitialData'

export default {
  middleware: ['auth', 'student'],

  name: 'indicators',

  components: {
    FunctionalStateInitialData,
    PhysicalFitnessInitialData
  }
}
</script>


<style lang="scss" scoped>
</style>
