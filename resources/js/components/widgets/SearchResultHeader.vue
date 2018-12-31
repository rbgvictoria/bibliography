<template>
  <div class="query-result-header">
    <div class="num-matches">
      Showing <b>{{ numMatches.first }}</b> to <b>{{ numMatches.last }}</b> of <b>{{ numMatches.total }}</b> matches
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      numMatches: {
        type: Object
      }
    }
  }
</script>

<style>
.query-result-header {
  margin: 20px 0;
}

.num-matches {
  padding: 7px 0;
}
</style>
