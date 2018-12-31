<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h2 v-if="formData">Reference: {{ `${formData.author} (${formData.publicationYear})` }}
            <span class="h4"><small>{{ formData.id }}</small></span></h2>
        <br/>
        <form class="form-horizontal">
          <form-generator
              :schema="schema"
              :value="formData"
              :labelWidth="labelWidth"
              :controlWidth="controlWidth"
              :vuexAction="vuexAction"
              @input="updateState"
              @selected="changeParent"
              ></form-generator>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import FormGenerator from "../components/widgets/forms/FormGenerator"
import ContributorList from '../models/ContributorListClass'
import schema from '../helpers/formConfig'
import Reference from '../models/ReferenceModel'

export default {
  name: "Reference",
  components: { FormGenerator },
  data() {
    return {
      labelWidth: 'col-md-2',
      controlWidth: 'col-md-10',
      vuexAction: 'reference/updateProperty'
    }
  },
  computed: {
    formData() {
      const reference = this.$store.getters['reference/getReference']
      return Vue.util.extend({}, reference)
    },
    schema() {
      if (this.formData) {
        return schema[this.formData.type]
      }
      return []
    }
  },
  methods: {
    updateState(fieldName, value) {
      this.$store.dispatch('reference/updateProperty', {
        name: fieldName,
        value: value}
      )
    },
    changeParent(item) {
      if (item.value !== this.formData.parent.id) {
        if (item.value) {
          this.$store.dispatch('reference/updateParent', item.value)
              .then(result => {
                this.formData.parent = result
          })
        }
        else {
          this.$store.dispatch('reference/dropParent', item.value)
            .then(result => {
              delete(this.formData.parent)
            })
        }
      }
    }
  },
  beforeRouteUpdate(to, from, next) {
      this.$store.dispatch('reference/get', to.params.id)
      next()
  }
}
</script>
