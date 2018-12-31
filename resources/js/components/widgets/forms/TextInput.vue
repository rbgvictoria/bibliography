<template>
  <div class="form-group">
    <label :for="name" :class="labelClasses">{{label}}</label>
    <div :class="controlDivClasses">
      <input
          type="text"
          class="form-control"
          :id="name"
          :name="name"
          :value="value"
          @input="onInput"
          :placeholder="placeholder"/>
    </div>
  </div>
</template>
<script>

export default {
  name: 'TextInput',
  props: ['placeholder', 'label', 'name', 'value', 'labelWidth', 'controlWidth'],
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
