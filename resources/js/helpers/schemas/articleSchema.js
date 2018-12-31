import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'author',
  'publicationYear',
  'title',
  'journal',
  'volume',
  'issue',
  'pageStart',
  'pageEnd',
  'number',
  'doi',
  'citationHtml'
]

const articleSchema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)
articleSchema.sort((a, b) => {
  return fields.indexOf(a.name) - fields.indexOf(b.name)
})

export default articleSchema
