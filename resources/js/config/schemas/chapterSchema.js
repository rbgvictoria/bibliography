import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'contributors',
  'authorString',
  'publicationYear',
  'title',
  'book',
  'pageStart',
  'pageEnd',
  'pages'
]

const chapterSchema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)
chapterSchema.sort((a, b) => {
  return fields.indexOf(a.name) - fields.indexOf(b.name)
})

export default chapterSchema
