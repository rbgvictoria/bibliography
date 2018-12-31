<template>
  <div class="form-group">
    <label :for="name" :class="labelClasses">{{label}}</label>
    <div :class="controlDivClasses">
      <autocomplete
        :id="name"
        :source="source"
        :focus="focus"
        :selected="select"
        :renderItem="renderItem"
        :classes="'form-control'"
        :value="selected ? selected.label : null"
        placeholder="Start typing..."
        @input="onInput"
        @selected="onSelected"></autocomplete>
      <p
        class="autocomplete-display"
        v-html="selected ? selected.display : null"></p>
    </div>
  </div>
</template>

<script>

import Autocomplete from '../Autocomplete'

export default {
  name: 'AutocompleteControl',
  components: {
    Autocomplete
  },
  props: ['placeholder', 'label', 'name', 'value', 'vuexAction', 'labelWidth',
      'controlWidth', 'source', 'hidden'],
  data() {
    return {
      selected: this.value,
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
      if (this.vuexAction) {
        this.$store.dispatch('reference/updateProperty', {
          name: event.target.name,
          value: event.target.value
        })
      }
    },
    focus ( event, ui ) {
      event.target.value = ui.item.label
      return false;
    },
    select( event, ui ) {
      if (ui.item.display) {
        $(event.target).next('.autocomplete-display').val(ui.item.display)
      }
    },
    onInput(val) {
      this.selected.value = ''
    },
    onSelected(item) {
      this.selected = item
      this.$emit('input', item.label)
      this.$emit('selected', item)
    },
    renderItem(ul, item) {
      ul.addClass('journal-autocomplete-dropdown')
      return $( "<li>" )
        .append('<div>' + item.label + '<div>')
        .appendTo( ul );
    }
  }
}
</script>

<style>
.autocomplete-display {
  margin-top: 10px;
}
</style>
