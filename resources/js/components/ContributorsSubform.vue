<template>
  <div class="form-group">
    <label class="label-control col-md-2">{{ label }}</label>
    <div class="col-md-10">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th class="col-xs-1">#</th>
            <th class="col-xs-8">Name</th>
            <th class="col-xs-1"><span class="padding"><i class="fa fa-user fa-lg"></i></span></th>
            <th class="col-xs-2"></th>
          </tr>
        </thead>
        <tbody>
          <contributors-subform-table-row 
              v-for="contributor in contributors" 
              :key="contributor.agent.id" 
              :contributor="contributor" 
              @author-selected="onAuthorSelected" 
              @new-agent-button-clicked="onNewAgentButtonClicked"
              @delete-contributor-button-clicked="deleteContributor"
              @add-contributor-button-clicked="addContributor" />
        </tbody>
      </table>
    </div>
    <modal-window ref="agentModal">
      <agent-form 
          :agent="agent" 
          @cancel-button-clicked="onNewAgentCancelButtonClicked"
          @save-button-clicked="onNewAgentSaveButtonClicked" />
    </modal-window>
  </div>
</template>

<script>
import Agent from '../models/AgentModel'
import Contributor from '../models/ContributorModel'
import ContributorsSubformTableRow from './ContributorsSubformTableRow'
import ModalWindow from './widgets/ModalWindow'
import AgentForm from './AgentForm'

export default {
  name: 'ContributorsSubform',
  components: {
    ContributorsSubformTableRow,
    ModalWindow,
    AgentForm
  },
  props: ['label', 'value'],
  data: function() {
    return {
      contributors: this.value,
      agent: new Agent(),
      activeContributor: false
    }
  },
  methods: {
    onAuthorSelected(item, index) {
      this.contributors[index].agent = item
      this.$emit('input', this.contributors)
    },
    onNewAgentButtonClicked(contributor) {
      this.activeContributor = contributor
      this.$refs.agentModal.modalOpen = true
    },
    deleteContributor(event) {
      event.preventDefault()
      const rowIndex = this.getRowIndex(event.target)
      this.contributors.splice(rowIndex, 1)
      this.updateSequence()
      this.$emit('input', this.contributors)
    },
    addContributor(event) {
      event.preventDefault()
      const rowIndex = this.getRowIndex(event.target)
      const contr = new Contributor()
      contr.role = this.contributors[rowIndex].role
      this.contributors.splice(rowIndex+1, 0, contr)
      this.updateSequence()
    },
    getRowIndex(elem) {
      const rowIndex = Number(elem.closest('tr').firstChild.innerText)
      return rowIndex
    },
    updateSequence() {
      this.contributors = this.contributors.map((contr, index) => {
        contr.sequence = index
        return contr
      })
    },
    onNewAgentCancelButtonClicked() {
      this.$refs.agentModal.modalOpen = false
      this.activeContributor = false
      this.agent = new Agent()
    },
    onNewAgentSaveButtonClicked(agent) {
      this.$store.dispatch('reference/storeAgent', {
        agent: agent, 
        contributor: this.activeContributor
      })
      this.$refs.agentModal.modalOpen = false
      this.activeContributor = false
      this.agent = new Agent()
      this.$emit('input', this.contributors)
    }
  }
}
</script>

<style scoped>
.padding {
  padding-left: 13px;
  padding-right: 13px;
}
</style>



