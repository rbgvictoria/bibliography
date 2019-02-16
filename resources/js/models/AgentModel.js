export default class Agent {

  constructor (ag = {}) {
    this.id = ag.id || null
    this.type = ag.type || 'Person'
    this.name = ag.name || null
    this.lastName = ag.lastName || null
    this.firstName = ag.firtsName || null
    this.initials = ag.initials || null
  }
}
