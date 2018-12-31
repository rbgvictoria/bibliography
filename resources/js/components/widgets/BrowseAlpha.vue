<template>
  <div>
    <div class="browse-alpha">
      <button
          v-for="letter in alpha" :key="letter"
          :class="{active: letter === firstLetter}"
          @click="onClick(letter)"
      >{{ letter.toUpperCase() }}</button>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    firstLetter: {
      type: String,
      default: 'a'
    }
  },
  data() {
    return {
      alpha: this.generateAlphaArray(),
    }
  },
  methods: {
    generateAlphaArray() {
      var alpha = [], i = 'a'.charCodeAt(0), j = 'z'.charCodeAt(0)
      for (i; i <= j; ++i) {
          alpha.push(String.fromCharCode(i))
      }
      return alpha
    },
    onClick(letter) {
      this.$emit('letterClicked', letter)
    }
  }
}

</script>

<style>
.browse-alpha > button {
    display: inline-block;
    text-align: center;
    width: 26px;
    padding: 3px;
    border: solid 1px #bb9d13;
    border-radius: 4px;
    margin: 1px;
    color: #bb9d13;
    cursor: pointer;
}

.browse-alpha > button.active {
    font-weight: bold;
    background-color: #bb9d13;
    color: #fff;
    text-decoration: none;
}
</style>
