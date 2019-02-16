<template>
  <tr>
    <td><div class="form-control-static">{{ contributor.sequence }}</div></td>
    <td>
      <author-autocomplete
          :value="contributor.agent.name"
          :author="contributor.agent.name"
          @author-selected="onAuthorSelected"
          :container="contributor"
          >{{ contributor.agent.name }}</author-autocomplete>
    </td>
    <td>
      <button class="btn btn-primary" title="Create new agent" @click="onNewAgentButtonClicked"><i class="fa fa-plus fa-lg"></i></button>
    </td>
    <td class="text-right">
      <button class="btn btn-danger" title="Delete contributor" @click="onDeleteContributorButtonClicked"><i class="fa fa-minus fa-lg"></i></button>
      <button class="btn btn-primary" title="Add contributor" @click="onAddContributorButtonClicked"><i class="fa fa-plus fa-lg"></i></button>
    </td>
  </tr>
</template>

<script>
import AuthorAutocomplete from './AuthorAutocomplete'

export default {
  name: 'ContributorsSubformTableRow',
  components: {
    AuthorAutocomplete
  },
  props: ['contributor'],
  methods: {
    onAuthorSelected(item) {
      this.$emit('author-selected', item, this.contributor.sequence)
    },
    onNewAgentButtonClicked(event) {
      event.preventDefault()
      this.$emit('new-agent-button-clicked', this.contributor)
    },
    onDeleteContributorButtonClicked(event) {
      this.$emit('delete-contributor-button-clicked', event)
    },
    onAddContributorButtonClicked(event) {
      this.$emit('add-contributor-button-clicked', event)
    }
  }
}
</script>

