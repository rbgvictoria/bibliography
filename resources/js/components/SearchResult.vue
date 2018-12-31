<template>
  <ul id="reference-list">
    <li v-for="citation in citations" :key="citation.id">
      <search-result-item :citation="citation"></search-result-item>
    </li>
  </ul>
</template>

<script>
import SearchResultItem from './SearchResultItem'

export default {
  components: {
    SearchResultItem
  },
  props: ['citations']
}
</script>

<style>
#reference-list {
  list-style: none;
  padding: 5px 0;
}

#reference-list > li {
  padding: 5px 0;
}

#reference-list > li .author-year {
  font-weight: bold;
}
</style>
