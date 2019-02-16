import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'title'
]

const schema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)
schema.sort((a, b) => {
  return fields.indexOf(a.name) - fields.indexOf(b.name)
})

export default schema
