import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'author',
  'publicationYear',
  'title',
  'book',
  'pageStart',
  'pageEnd',
  'pages',
  'citationHtml'
]

const chapterSchema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)

export default chapterSchema
