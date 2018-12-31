import Agent from './AgentModel'

export default class Contributor {

  constructor (contr = {}) {
    this.sequence = contr.sequence
    this.role = contr.role,
    this.agent = new Agent(contr.agent)
  }

}
