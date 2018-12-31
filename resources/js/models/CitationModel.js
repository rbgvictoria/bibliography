export default class Citation {

  constructor(data = {}) {
    this.id = data.id,
    this.type = data.type,
    this.author = data.author,
    this.year = data.year,
    this.citationHtml = data.citationHtml
  }

  get citation () {
    const search = /^\<strong\>([^\<]+)\<\/strong\>(\.)/
    return this.citationHtml.replace(search, '')
  }
}
