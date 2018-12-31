export default class Agent {

  constructor (ag = {}) {
    this.id = ag.id,
    this.type = ag.type,
    this.name = ag.name,
    this.lastName = ag.lastName,
    this.firstName = ag.firtsName,
    this.initials = ag.initials
  }
}
