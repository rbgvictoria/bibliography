<template>
  <div class="form-group">
    <label for="name" :class="labelClasses">{{ label }}</label>
    <div :class="controlDivClasses">
      <select
        class="form-control"
        :id="name"
        :name="name"
        :multiple="multi"
        :value="value"
        @input="onInput">
        <option v-for="option in options" :key="option.value" :value="option.value">
          {{ option.label }}
        </option>
      </select>
    </div>
  </div>
</template>
<script>
export default {
  name: 'SelectList',
  props: ['multi', 'options', 'name', 'label', 'value', 'labelWidth', 'controlWidth'],
  data() {
    return {
      labelClasses: [
        this.labelWidth || 'col-md-2',
        'control-label',
        'text-left'
      ],
      controlDivClasses: [this.controlWidth || 'col-md-10']
    }
  },
  methods: {
    onInput(event) {
      this.$emit('input', event.target.value)
    }
  }
}
</script>
