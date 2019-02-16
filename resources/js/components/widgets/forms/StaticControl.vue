<template>
  <div :class="classes">
    <label :class="labelClasses">{{label}}</label>
    <div v-if="value" :class="controlDivClasses">
      <p v-if="['number', 'string'].indexOf(typeof value) > -1" class="form-control-static" v-html="value"></p>
      <p v-else-if="value" class="form-control-static">
        <span v-if="typeof value.display !== 'undefined'" v-html="value.display"></span>
        <span v-else-if="typeof value.label !== 'undefined'" v-html="value.label"></span>
        <router-link v-if="value.value" :to="{name: 'reference', params: {id: value.value}}" v-html="`<i class='fa fa-search'></i>`"></router-link>
      </p>
    </div>
  </div>
</template>
<script>
export default {
  name: 'StaticControl',
  props: ['label', 'value', 'labelWidth', 'controlWidth', 'hide'],
  data() {
    return {
      classes: {
        'form-group': true,
        hidden: this.hide
      },
      labelClasses: [
        this.labelWidth || 'col-md-2',
        'control-label',
        'text-left'
      ]
    }
  },
  computed: {
    controlDivClasses() {
      return [this.controlWidth || 'col-md-10']
    }
  }
}
</script>

<style scoped>
  .hidden {
    display: none;
  }
</style>

