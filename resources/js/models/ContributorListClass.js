export default class ContributorList {
  constructor(data = {}) {
    this.contributors = data.data
  }

  get contributorString() {
    const contributors = this.contributors.sort((a, b) => {
      return a.sequence-b.sequence
    })
    const arr = contributors.map(contributor => {
      let agent = contributor.agent.lastName
      if (contributor.agent.initials) {
        agent += ', ' + contributor.agent.initials
      }
      return agent
    })
    let str = arr.join('; ')
    if (this.contributors[0].role === 'Editor') {
      if (this.contributors.length === 1) {
        str += ' (ed.)'
      }
      else {
        str += ' (eds)'
      }
    }
    return str
  }
}
