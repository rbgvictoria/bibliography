<template>
  <div>
    <component
        v-for="(field, index) in schema"
        :key="index"
        :is="field.fieldType"
        :value="formData[field.name]"
        :labelWidth="field.labelWidth || labelWidth"
        :controlWidth="field.controlWidth || controlWidth"
        @input="updateForm(field.name, $event)"
        @selected="onSelected"
        v-bind="field">
    </component>
  </div>
</template>

<script>
import NumberInput from "./NumberInput"
import SelectList from "./SelectList"
import TextInput from "./TextInput"
import StaticControl from "./StaticControl"
import AutocompleteControl from "./AutocompleteControl"
import Reference from "../../../models/ReferenceModel"

export default {
  name: "FormGenerator",
  components: { NumberInput, SelectList, TextInput, StaticControl, AutocompleteControl },
  props: ["schema", "value", 'vuexAction', 'labelWidth', 'controlWidth'],
  data() {
    return {
      formData: this.value || {}
    }
  },
  methods: {
    updateForm(fieldName, value) {
      this.$set(this.formData, fieldName, value)
      this.$emit("input", fieldName, value)
    },
    onSelected(item) {
      this.$emit('selected', item)
    }
  },
  watch: {
    value() {
      this.formData = this.value
    }
  }
}
</script>
