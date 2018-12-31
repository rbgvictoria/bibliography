import store from '../store'

export default class Pagination {
  constructor (data = {}) {
    this.total = data.total,
    this.count = data.count,
    this.per_page = data.per_page,
    this.current_page = data.current_page,
    this.total_pages = data.total_pages,
    this.links = data.links
  }

  get numMatches () {
    return {
      total: this.total,
      first: ((this.current_page-1) * this.per_page) +1,
      last: (this.current_page * this.per_page < this.total)
        ? this.current_page * this.per_page : this.total
    }
  }
}
