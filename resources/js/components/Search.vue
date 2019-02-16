<template>
  <div class="container">
      <div class="row">

          <div class="col-md-4">
            <author-autocomplete
                :value="author"
                :author="author"
                @author-selected="onAuthorSelected"
                >{{ $route.query.author }}</author-autocomplete>
          </div>

          <div class="col-md-8">
            <browse-alpha
              :firstLetter="letter"
              @letterClicked="onLetterClicked"
            />
          </div>

          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6" v-if="numMatches">
                <search-result-header
                    :numMatches="numMatches"
                    ></search-result-header>
              </div>
              <div class="col-md-6 text-right">
                <pagination
                    v-if="showPagination"
                    :total-pages="pagination.total_pages"
                    :total="pagination.total"
                    :per-page="pagination.per_page"
                    :current-page="pagination.current_page"
                    @pagechanged="onPageChange"
                 />
              </div>
            </div>
            <search-result :citations="citations"></search-result>
            <div class="text-right">
              <pagination
                  v-if="showPagination"
                  :total-pages="pagination.total_pages"
                  :total="pagination.total"
                  :per-page="pagination.per_page"
                  :current-page="pagination.current_page"
                  @pagechanged="onPageChange"
               />
            </div>
          </div>


      </div>
  </div> <!-- /.container -->

</template>

<script>
import AuthorAutocomplete from './AuthorAutocomplete'
import BrowseAlpha from './widgets/BrowseAlpha'
import SearchResult from './SearchResult'
import SearchResultHeader from './widgets/SearchResultHeader'
import Pagination from './widgets/Pagination'

export default {
  components: {
    AuthorAutocomplete,
    BrowseAlpha,
    SearchResultHeader,
    SearchResult,
    Pagination
  },
  data() {
    return {
      selected: null,
      model: null
    }
  },
  computed: {
    citations() {
      return this.$store.getters['citations/getCitations']
    },
    pagination() {
      return this.$store.getters['citations/getPagination']
    },
    numMatches() {
      if (this.pagination) {
        return this.pagination.numMatches
      }
      return null
    },
    letter() {
      return this.getFirstLetter()
    },
    author() {
      return this.getAuthor()
    },
    showPagination() {
      return this.pagination && this.pagination.total_pages > 1
    }
  },
  methods: {
    getFirstLetter: function() {
      const author = this.$route.query.author
      if (author) {
        return author.substr(0,1).toLowerCase()
      }
      else {
        return 'a'
      }
    },
    getAuthor() {
      const author = this.$route.query.author
      if (author && author.length > 2) {
        return author
      }
      else {
        return ''
      }
    },
    onAuthorSelected: function(item) {
      this.$router.push({name: 'search', query: {author: item.name}})
    },
    onLetterClicked: function(letter) {
      this.$router.push({name: 'search', query: {author: letter.toUpperCase()}})
    },
    onPageChange: function(page) {
      let qry = Object.assign({}, this.$store.getters['citations/getQuery'])
      qry.page = page
      this.$router.push({ name: 'search', query: qry })
    }
  },
  mounted() {
    if (typeof this.$route.query.author === 'undefined') {
      this.$router.push({name: 'search', query: {author: 'A'}})
    }
  },
  watch: {
    '$route'(to) {
      this.$store.dispatch('citations/search', to.query )
    }
  }
}
</script>
