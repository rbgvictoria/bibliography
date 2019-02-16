<template>
  <div>
    <div v-if="$store.getters['auth/checkAuth']" class="text-right">
      <button 
        class="btn btn-primary" 
        :disabled="toggleDisabled"
        @click="toggleEditable"
        :title="editable ? 'View' : 'Edit'"
        v-html="editable ? `<i class='fa fa-eye fa-lg'></i>` : `<i class='fa fa-edit fa-lg'></i>`"
      ></button>
      <button class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
    </div>
    <br/>
    <form class="form-horizontal">
      <form-generator
          :schema="schema"
          :value="formData"
          :labelWidth="labelWidth"
          :controlWidth="controlWidth"
          :vuexAction="vuexAction"
          :staticForm="!editable"
          @input="updateState"
          @selected="changeParent"
          ></form-generator>
    </form>
    <div v-if="editable">
      <button class="btn btn-primary" :disabled="submitDisabled" @click="saveEdits" title="Save"><i class="fa fa-save fa-lg"></i></button>
      <button class="btn btn-primary" :disabled="submitDisabled" @click="cancelEdit" title="Cancel"><i class="fa fa-ban fa-lg"></i></button>
    </div>
  </div>
</template>

<script>
import FormGenerator from "../components/widgets/forms/FormGenerator"
import schema from '../config/formConfig'
import Reference from '../models/ReferenceModel'
import Agent from '../models/AgentModel'

export default {
  name: "ReferenceForm",
  components: { FormGenerator },
  props: ['value'],
  data() {
    return {
      labelWidth: 'col-md-2',
      controlWidth: 'col-md-10',
      vuexAction: 'reference/updateProperty',
      editable: false,
      toggleDisabled: false,
      submitDisabled: true,
    }
  },
  computed: {
    formData() {
      return this.value
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
      if (fieldName === 'contributors') {
        this.updateAuthorCitation()
      }
      this.toggleDisabled = true;
      this.submitDisabled = false;
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
    },
    toggleEditable() {
      this.editable = !this.editable
    },
    cancelEdit() {
      this.editable = false
      this.toggleDisabled = false
      this.submitDisabled = true
      this.$store.dispatch('reference/get', this.$route.params.id)
    },
    saveEdits() {
      const agentName = this.formData.authorString
      new Promise((resolve, reject) => {
        if (agentName === this.formData.author.name) {
          resolve(this.formData.author)
        }
        else {
          resolve(this.findAgent(agentName).then(response => {
            if (typeof response.data === 'object' && Object.keys(response.data).length) {
              return response.data
            }
            else {
              return this.createAgent(agentName).then(response => {
                return response.data
              })
            }
          }))
        }
      }).then(data => {
        this.$store.dispatch('reference/updateProperty', {
          name: 'author',
          value: data
        })
        this.$store.dispatch('reference/updateReference', this.formData)
      })
      this.editable = false
      this.toggleDisabled = false
      this.submitDisabled = true
      this.$store.dispatch('reference/updateReference', this.formData)
    },
    updateAuthorCitation() {
      this.$store.dispatch('reference/updateProperty', {
        name: 'authorString',
        value: Reference.getAuthorString(this.formData)
      })
      const citation = Reference.citationString(this.formData)
      this.$store.dispatch('reference/updateProperty', {
        name: 'citationHtml',
        value: citation
      })
      this.$store.dispatch('reference/updateProperty', {
        name: 'citation',
        value: citation.replace(/(<([^>]+)>)/ig, '')
      })
    },
    findAgent(name) {
      return axios('/api/agents/findByName?name=' + encodeURIComponent(name))
    },
    createAgent(name) {
      const agent = new Agent()
      agent.name = name
      agent.type = 'Group'
      agent.groupMembers = this.formData.contributors.map(contr => {
        return {
          sequence: contr.sequence,
          member: contr.agent
        }
      })
      return axios.post('/api/agents', agent)

    }
  },
  beforeRouteUpdate(to, from, next) {
    this.$store.dispatch('reference/get', to.params.id)
    next()
  }
}
</script>
