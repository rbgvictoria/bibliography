<template>
  <input
    :class="classes"
    :placeholder="placeholder"
    :value="value"
    @input="onInput"
    @change="onChange"/>
</template>

<script>
  import 'jquery-ui/ui/core'
  import 'jquery-ui/ui/widgets/autocomplete'
  import '../../../../node_modules/jquery-ui/themes/base/autocomplete.css'
  import '../../../../node_modules/jquery-ui/themes/base/menu.css'
  import '../../../../node_modules/jquery-ui/themes/base/theme.css'

  export default {
    props: {
      source: {
        type: [String, Array, Function],
        required: true
      },
      minLength: {
        type: Number,
        default: 2
      },
      focus: Function,
      selected: Function,
      renderItem: Function,
      placeholder: String,
      classes: [String, Array],
      value: String
    },
    mounted() {
      const self = this
      if (this.focus) {
        $(this.$el).on( "autocompletefocus", this.focus )
      }
      $(this.$el).on( 'autocompleteselect', (event, ui) => {
        if (this.selected) {
          this.selected(event, ui)
        }
        this.$emit('selected', ui.item)
      })

      $(this.$el).autocomplete({
        source: this.source,
        minLength: this.minLength
      })
      if (this.renderItem) {
        $(this.$el).autocomplete()
            .data("uiAutocomplete")._renderItem = this.renderItem
      }
    },
    beforeDestroy() {
      $(this.$el).autocomplete('destroy')
    },
    methods: {
      onInput (event) {
        this.$emit('input', event.target.value)
      },
      onKeypressEnter (e) {
        this.$emit('keypress-enter', e)
      },
      onChange (e) {
        this.$emit('change', e)
      }
    }
  }
</script>

<style>
  .ui-helper-hidden-accessible {
    display: none;
  }
</style>
