import Agent from './AgentModel'

export default class Contributor {

  constructor (contr = {}) {
    this.sequence = contr.sequence
    this.agent = new Agent(contr.member)
  }

}
