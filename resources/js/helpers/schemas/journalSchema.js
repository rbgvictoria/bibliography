import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'title',
  'citationHtml'
]

const schema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)

export default schema
