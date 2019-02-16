import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'contributors',
  'authorString',
  'publicationYear',
  'title',
  'journal',
  'volume',
  'issue',
  'pageStart',
  'pageEnd',
  'number',
  'doi'
]

const articleSchema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)
articleSchema.sort((a, b) => {
  return fields.indexOf(a.name) - fields.indexOf(b.name)
})

export default articleSchema
