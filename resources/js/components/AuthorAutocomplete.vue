<template>
  <div class="search-form form-horizontal">
    <div class="input-group">
      <autocomplete
        id="author-autocomplete"
        :source="source"
        :renderItem="renderItem"
        :focus="focus"
        :classes="'form-control'"
        :value="model"
        placeholder="Start typing..."
        @input="onInput"
        @selected="onSelected"></autocomplete>
      <span class="input-group-addon">
        <i class="fa fa-search fa-lg"></i>
      </span>
    </div>
  </div>
</template>

<script>

  import Autocomplete from './widgets/Autocomplete'

  export default {
    components: {
      Autocomplete
    },
    props: {
      author: String 
    },
    data() {
      return {
        source: '/api/autocomplete/author',
        model: this.author
      }
    },
    methods: {
      onInput(val) {
        this.model = val
      },
      onSelected(item) {
        this.$emit('author-selected', item)
      },
      focus ( event, ui ) {
        event.target.value = ui.item.name
        return false;
      },
      renderItem(ul, item) {
        ul.addClass('author-autocomplete-dropdown');
        return $( "<li>" )
          .append('<div>' + item.name + '<div>')
          .appendTo( ul );
      }
    },
    watch: {
      '$route': function() {
        this.model = this.author
      }
    }
  }

</script>

<style>
  .search-form .input-group-addon {
    cursor: pointer;
  }

  .author-autocomplete-dropdown {
    z-index: 10000;
  }
</style>
