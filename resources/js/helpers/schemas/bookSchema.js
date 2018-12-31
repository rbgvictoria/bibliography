import defaultSchema from './defaultSchema'

const fields = [
  'type',
  'author',
  'publicationYear',
  'title',
  'publisher',
  'placeOfPublication',
  'numberOfPages',
  'isbn',
  'doi',
  'citationHtml'
]

const bookSchema = defaultSchema.filter(field => fields.indexOf(field.name) > -1)

export default bookSchema
