<template>
  <div class="form-group">
    <label :class="labelClasses">{{label}}</label>
    <div :class="controlDivClasses">
      <p class="form-control-static" v-html="value"></p>
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
      ],
      controlDivClasses: [this.controlWidth || 'col-md-10']
    }
  }
}
</script>
