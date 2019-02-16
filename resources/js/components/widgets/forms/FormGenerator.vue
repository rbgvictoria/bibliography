<template>
  <div>
    <component
        v-for="(field, index) in schema"
        :key="index"
        :is="staticForm ? 'StaticControl' : field.fieldType"
        :value="formData[field.name]"
        :labelWidth="field.labelWidth || labelWidth"
        :controlWidth="field.controlWidth || controlWidth"
        :hide="field.hideInStaticMode || hide"
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
import ContributorsSubform from "../../ContributorsSubform"

export default {
  name: "FormGenerator",
  components: { NumberInput, SelectList, TextInput, StaticControl, AutocompleteControl, ContributorsSubform },
  props: {
    schema: Array,
    value: Object,
    vuexAction: String,
    labelWidth: String,
    controlWidth: {
      type: String,
      default: 'col-md-10'
    },
    staticForm: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      formData: this.value || {},
      hide: false
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
