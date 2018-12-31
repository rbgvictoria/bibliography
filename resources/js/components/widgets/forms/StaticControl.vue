<template>
  <div class="form-group">
    <label :class="labelClasses">{{label}}</label>
    <div v-if="value" :class="controlDivClasses">
      <p v-if="typeof value === 'string'" class="form-control-static" v-html="value"></p>
      <p v-else class="form-control-static">
        {{value.label}}
        <router-link :to="{name: 'reference', params: {id: value.value}}" v-html="`<i class='fa fa-search'></i>`"></router-link>
      </p>
    </div>
  </div>
</template>
<script>
export default {
  name: 'StaticControl',
  props: ['label', 'value', 'labelWidth', 'controlWidth'],
  data() {
    return {
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
