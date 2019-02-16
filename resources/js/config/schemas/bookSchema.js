import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'contributors',
  'authorString',
  'publicationYear',
  'title',
  'publisher',
  'placeOfPublication',
  'numberOfPages',
  'isbn',
  'doi'
]

const bookSchema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)
bookSchema.sort((a, b) => {
  return fields.indexOf(a.name) - fields.indexOf(b.name)
})

export default bookSchema
