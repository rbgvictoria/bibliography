<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <header v-if="reference && reference.citation">
          <h3 v-html="reference.title.replace(/\*([^\*]+)\*/g, '<i>$1</i>')"></h3>
          <p v-if="reference.citation !== reference.title" v-html="reference.citationHtml"></p>
        </header>
        <reference-form :value="reference" />
      </div>
    </div>
  </div>
</template>

<script>
import ReferenceForm from './ReferenceForm'
import Vue from 'vue';

export default {
  name: 'ReferencePage',
  components: {
    ReferenceForm
  },
  computed: {
    reference() {
      return Vue.util.extend(this.$store.getters['reference/getReference'])
    }
  }
}
</script>

<style>

</style>


