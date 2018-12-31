<template>
  <div class="reference-list-item">
    <span class="author-year">{{ citation.author }} ({{ citation.year }})</span>
    <router-link
        :to="{ name: 'reference', params: { id: citation.id } }"
        ><i class="fa fa-search"></i></router-link><br/>
    <span class="citation" v-html="citation.citation"></span>
  </div>
</template>


<script>
import Citation from '../models/CitationModel'

export default {
  name: 'ReferenceListItem',
  props: {
    citation: {
      type: Citation,
      required: true
    }
  }
}
</script>
