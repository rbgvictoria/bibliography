<template>
  <div class="modal-content">
    <div class="modal-header">
      <h4>Create new Agent</h4>
    </div>
    <div class="modal-body form">
      <label for="agent-type">Type</label>
      <select id="agent-type" class="form-control" v-model="formData.type">
        <option value="Person">Person</option>
        <option value="Group" disabled>Group</option>
        <option value="Organization">Organisation</option>
      </select>
      <label for="name" class="control-label">Name</label>
      <input id="name" type="text" v-model="formData.name" class="form-control" />
      <label for="last-name">Last name</label>
      <input id="last-name" type="text" v-model="formData.lastName" class="form-control" :disabled="inputDisabled" />
      <label for="initials">Initials</label>
      <input id="initials" type="text" v-model="formData.initials" class="form-control" :disabled="inputDisabled" />
      <label for="first-name">First name(s)</label>
      <input id="first-name" type="text" v-model="formData.firstName" class="form-control" :disabled="inputDisabled" />
    </div>
    <div class="modal-footer clearfix">
      <button class="btn btn-primary" @click="onSaveButtonClicked"><i class="fa fa-save fa-lg"></i></button>
      <button class="btn btn-primary" @click="onCancelButtonClicked"><i class="fa fa-ban fa-lg"></i></button>
    </div>
  </div>
</template>

<script>
import schema from '../config/schemas/agentSchema'
import Agent from '../models/AgentModel'

export default {
  name: 'AgentForm',
  props: {
    agent: {
      type: Agent,
      required: false
    }
  },
  data() {
    return {
      formData: this.value || new Agent()
    }
  },
  computed: {
    inputDisabled() {
      return this.formData.type !== 'Person'
    }
  },
  methods: {
    updateName() {
      if (this.formData.type === 'Person') {
        this.formData.name = this.formData.initials ? `${this.formData.lastName}, ${this.formData.initials}` : this.formData.lastName
      }
    },
    updateLastNameInitials() {
      if (this.formData.type === 'Person') {
        const bits = this.formData.name.split(/, ?/)
        this.formData.lastName = bits[0]
        if (typeof bits[1] !== 'undefined') {
          this.formData.initials = bits[1]
        }
      }
    },
    onCancelButtonClicked(event) {
      event.preventDefault()
      this.$emit('cancel-button-clicked')
    },
    onSaveButtonClicked(event) {
      event.preventDefault()
      this.$emit('save-button-clicked', this.formData)
    }
  },
  watch: {
    'formData.lastName'() {
      this.updateName()
    },
    'formData.initials'() {
      this.updateName()
    },
    'formData.name'() {
      this.updateLastNameInitials()
    }
  }
}
</script>

<style>

</style>


