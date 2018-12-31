import defaultSchema from './schemas/defaultSchema'
import articleSchema from './schemas/articleSchema'
import chapterSchema from './schemas/chapterSchema'
import bookSchema from './schemas/bookSchema'
import journalSchema from './schemas/journalSchema'

const schema = {
  Article: articleSchema,
  Book: bookSchema,
  Report: bookSchema,
  Chapter: chapterSchema,
  Webpage: defaultSchema,
  AudioVisualDocument: defaultSchema,
  Journal: journalSchema,
  Periodical: journalSchema,
  Series: defaultSchema,
  MultiVolumeBook: defaultSchema,
  Website: defaultSchema
}

export default schema
