import Vue from 'vue'

export default class Author {
  constructor (contributors = []) {
    if (contributors.length === 1) {
      const contr = Vue.util.extend({}, contributors[0])
      this.id = contr.agent.id
      this.type = contr.agent.type
      this.name = contr.agent.name
      this.lastName = contr.agent.lastName
      this.firstName = contr.agent.firstName
      this.initials = contr.agent.initials
    }
    else if (contributors.length > 1) {
      this.id = null
      this.type = 'Group'
      const personNames = contributors.map(contr => {
        const contributor = Vue.util.extend({}, contr)
        return contr.agent.name
      })
      this.name = personNames.join('; ').replace(/;([^;]*)$/, ' &$1')
      this.lastName = null
      this.firstName = null
      this.initials = null
      this.groupMembers = []
      for (let contr of contributors) {
        this.groupMembers.push(Vue.util.extend({sequence: contr.sequence}, contr.agent))
      }
    }
  }
}