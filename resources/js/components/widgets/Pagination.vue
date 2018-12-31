<template>
  <ul :class="classes">
    <li class="pagination-item">
      <button
        type="button"
        @click="onClickPreviousPage"
        :disabled="isInFirstPage"
        v-html="prevBtnHtml"
      ></button>
    </li><li class="pagination-item">
      <button
        type="button"
        @click="onClickFirstPage"
        :disabled="isInFirstPage"
        :class="{active: isInFirstPage}"
        v-html="1"
      ></button>
    </li><li class="pagination-item" v-if="pages.length && pages[0].name > 2">
      <button type="button" disabled>...</button>
    </li><li class="pagination-item"
      v-for="page in pages"
      :key="page.name"
    >
      <button
        type="button"
        @click="onClickPage(page.name)"
        :disabled="page.isDisabled"
        :class="{active: isActivePage(page.name)}"
        v-html="page.name"
      ></button>
    </li><li class="pagination-item" v-if="pages.length && pages[pages.length-1].name < totalPages - 1">
      <button type="button" disabled>...</button>
    </li><li class="pagination-item">
      <button
        type="button"
        @click="onClickLastPage"
        :disabled="isInLastPage"
        :class="{active: isInLastPage}"
      >{{ totalPages }}</button>
    </li><li class="pagination-item">
      <button
        type="button"
        @click="onClickNextPage"
        :disabled="isInLastPage"
        v-html="nextBtnHtml"
      ></button>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    classes: {
      type: String,
      default: 'pagination'
    },
    maxVisibleButtons: {
      type: Number,
      required: false,
      default: 5
    },
    totalPages: {
      type: Number,
      required: true
    },
    total: {
      type: Number,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    prevBtnHtml: {
      type: String,
      default: 'Previous'
    },
    nextBtnHtml: {
      type: String,
      default: 'Next'
    },
    firstBtnHtml: {
      type: String,
      default: 'First'
    },
    lastBtnHtml: {
      type: String,
      default: 'Last'
    }
  },
  computed: {
    startPage() {
      if (this.currentPage === 1) {
        return 1
      }
      if (this.currentPage === this.totalPages) {
        return this.totalPages - this.maxVisibleButtons
      }
      return this.currentPage - 1
    },
    pages() {
      const range = []
      for (let i = this.currentPage - (this.maxVisibleButtons - 1);
          i <= this.currentPage + (this.maxVisibleButtons - 1);
          i++) {
            if (i > 1 && i < this.totalPages && ((i == this.currentPage)
                || (i == this.currentPage - 1)
                || (i == this.currentPage + 1)
                || (this.currentPage < this.maxVisibleButtons
                  && i <= this.maxVisibleButtons)
                || (this.currentPage > this.totalPages - (this.maxVisibleButtons - 1)
                  && i >= this.totalPages - (this.maxVisibleButtons - 1)))) {
                  range.push({
                    name: i,
                    isDisabled: i === this.currentPage
                  });
        }
      }
      return range;
    },
    isInFirstPage() {
      return this.currentPage === 1
    },
    isInLastPage() {
      return this.currentPage === this.totalPages
    }
  },
  methods: {
    onClickFirstPage() {
      this.$emit('pagechanged', 1)
    },
    onClickPreviousPage() {
      this.$emit('pagechanged', this.currentPage - 1)
    },
    onClickPage(page) {
      this.$emit('pagechanged', page)
    },
    onClickNextPage() {
      this.$emit('pagechanged', this.currentPage + 1)
    },
    onClickLastPage() {
      this.$emit('pagechanged', this.totalPages)
    },
    isActivePage(page) {
      return this.currentPage === page
    }
  }
}
</script>

<style>
.pagination > li > button {
  position: relative;
  float: left;
  padding: 6px 12px;
  line-height: 1.42857143;
  text-decoration: none;
  color: #bb9d13;
  background-color: #fff;
  border: 1px solid #ddd;
  margin-left: -1px;
}

.pagination > li > button.active {
  color: #fff;
  background-color: #bb9d13;
  border-color: #bb9d13;
}
</style>
