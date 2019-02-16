<template>
  <div
      :class="{ modal: true, show: modalOpen}"
      id="modal" tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      @click.self="hide">
    <div class="modal-dialog" role="document">
      <slot />
    </div>
  </div>
</template>

<script>
  export default {
    name: 'ModalWindow',
    data() {
      return {
        modalOpen: false
      }
    },
    methods: {
      escapeKeyListener(evt) {
        if (evt.keyCode === 27 && this.modalOpen) {
            this.modalOpen = false;
        }
      },
      hide() {
        this.modalOpen = false;
      }
    },
    watch: {
      modalOpen() {
        const className = 'modal-open'
        if (this.modalOpen) {
          document.body.classList.add(className)
        }
        else {
          document.body.classList.remove(className)
        }
      }
    },
    created() {
      document.addEventListener('keyup', this.escapeKeyListener);
    },
    destroyed() {
      document.removeEventListener('keyup', this.escapeKeyListener);
    }
  }
</script>

<style>
  .modal {
    background-color: rgba(0, 0, 0, 0.5)
  }

  .modal-footer {
    padding-bottom: 20px;
  }
</style>
