import Vue from 'vue'
import Contributor from './ContributorModel'

export default class Reference {

  constructor(ref = {}) {
    this.id = ref.id
    this.type = ref.type
    this.publicationYear = ref.publicationYear
    this.title = ref.title
    this.parent = ref.parent ? new Reference(ref.parent) : null
    this.volume = ref.volume
    this.issue = ref.issue
    this.number = ref.number
    this.pageStart = ref.pageStart
    this.pageEnd = ref.pageEnd
    this.pages = ref.pages
    this.numberOfPages = ref.numberOfPages
    this.publisher = ref.publisher
    this.isbn = ref.isbn
    this.issn = ref.issn
    this.doi = ref.doi
    this.citation = ref.citation
    this.citationHtml = ref.citationHtml
    if (ref.author) {
      this.author = ref.author
      this.authorString = ref.author.name
      this.authorId = ref.author.id
      if (ref.author.type === 'Group') {
        this.contributors = ref.author.groupMembers.data
            .map(contr => new Contributor(contr))
            .sort((a, b) => {
              return a.sequence - b.sequence
            })
      }
      else {
        this.contributors = [new Contributor(ref.author)]
      }

    }
    if (this.parent && this.type === 'Chapter') {
      this.book = this.getBook()
    }
    if (this.parent && this.type === 'Article') {
      this.journal = this.getJournal()
    }
  }

  getBook() {
    return {
      label: this.parent.citation,
      value: this.parent.id,
      display: this.parent.citationHtml
    }
  }

  getJournal() {
    return {
      label: this.parent.title,
      value: this.parent.id
    }
  }

  static getAuthorString(reference) {
    return reference.contributors
        .sort((a, b) => a.sequence - b.sequence)
        .map(contr => {
          return contr.agent.name
        })
        .join('; ')
        .replace(/;([^;]*)$/,' &$1')
  }

  static citationString(reference) {
    let str = ''
    switch(reference.type) {
      case 'Journal':
      case 'Series':
        str += reference.title
        break;
      case 'Book':
      case 'Report':
      case 'AudioVisualDocument':
        str += '<b>' + reference.authorString + ' (' + reference.publicationYear + ').</b> '
        str += '<i>' + reference.title.replace(/\ *([^\*]+)\* /g, '</i> $1 <i>') + '</i>.'
        if (reference.publisher) {
          str += ' ' + reference.publisher
          if (reference.placeOfPublication) {
            str += ', ' + reference.placeOfPublication
          }
          str += '.'
        }
        break;
      case 'Article':
        str += '<b>' + reference.authorString + ' (' + reference.publicationYear + ').</b> '
        str += reference.title.replace(/\*([^\*]+)\*/g, '<i>$1</i>') + '. '
        str += '<i>' + reference.parent.title + '</i>'
        if (reference.volume) {
          str += ' <b>' + reference.volume + '</b>'
          if (reference.issue) {
            str += '(' + reference.issue + ')'
          }
          if (reference.pageStart) {
            str += ': ' + reference.pageStart
            if (reference.pageEnd) {
              str += '–' + reference.pageEnd
            }
          }
        }
        else if (reference.number) {
          str += ' ' + reference.number
        }
        str += '.'
        break;
      case 'Chapter':
        str += '<b>' + reference.authorString + ' (' + reference.publicationYear + ').</b> '
        str += reference.title.replace(/\*([^\*]+)\*/g, '<i>$1</i>') + '. '
        str += 'In: ' + reference.parent.authorString + ', '
        str += '<i>' + reference.title.replace(/\ *([^\*]+)\* /g, '</i> $1 <i>') + '</i>, '
        str += 'pp. ' + reference.pageStart + '–' + reference.pageEnd + '.'
        if (reference.parent.publisher) {
          str += ' ' + reference.parent.publisher
          if (reference.parent.placeOfPublication) {
            str += ', ' + reference.parent.placeOfPublication
          }
          str += '.'
        }
        break
    }
    return str
  }

}
