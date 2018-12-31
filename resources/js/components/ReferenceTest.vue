<template>
  <div>
    <h1>Hello</h1>
    <p>{{ reference.contributorString }}</p>
  </div>
</template>

<script>

export default {
  name: 'ReferenceTest',
  data() {
    return {
      reference: {}
    }
  },
  watch: {
    '$store.state.reference.reference'() {
        this.reference = Vue.util.extend({}, this.$store.getters['reference/getReference'])
    }
  }
}

</script>
