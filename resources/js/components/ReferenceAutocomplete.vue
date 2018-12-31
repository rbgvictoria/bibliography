<template>
  <div class="search-form form-horizontal">
    <div class="input-group">
      <auto-complete
        id="reference-autocomplete"
        :source="source"
        :renderItem="renderItem"
        :focus="focus"
        :classes="'form-control'"
        placeholder="Start typing..."
        @input="onInput"
        @select="onSelect"
        v-once></auto-complete>
      <span class="input-group-addon">
        <i class="fa fa-search fa-lg"></i>
      </span>
    </div>
  </div>
</template>

<script>

  import AutoComplete from './widgets/AutoComplete'

  export default {
    components: {
      AutoComplete
    },
    data() {
      return {
        source: '/api/autocomplete'
      }
    },
    methods: {
      onInput(val) {
        this.model = val
      },
      onSelect(item) {
        this.$store.dispatch('citations/storeCitations', {data: [item]})
      },
      focus ( event, ui ) {
        $('#reference-autocomplete').val( ui.item.citation ) // Note: need to
            // put an id on the <auto-complete> element
        return false;
      },
      renderItem(ul, item) {
        ul.addClass('reference-autocomplete-dropdown');
        return $( "<li>" )
          .append('<div>' + item.citationHtml + '<div>')
          .appendTo( ul );
      }
    }
  }

</script>

<style>
  .search-form .input-group-addon {
    cursor: pointer;
  }
</style>
