export default [
  {
    fieldType: "SelectList",
    name: "type",
    multi: false,
    label: "Type",
    options: [
      { value: 'Article', label: 'Article' },
      { value: 'Book', label: 'Book' },
      { value: 'Report', label: 'Report' },
      { value: 'Chapter', label: 'Chapter' },
      { value: 'Webpage', label: 'Webpage' },
      { value: 'AudioVisualDocument', label: 'Audio-visual Document' },
      { value: 'Journal', label: 'Journal' },
      { value: 'Periodical', label: 'Periodical' },
      { value: 'Series', label: 'Series' },
      { value: 'MultiVolumeBook', label: 'Multivolume Book' },
      { value: 'Website', label: 'Website' }
    ]
  },
  {
    fieldType: "StaticControl",
    name: "author",
    label: "Author(s)",
  },
  {
    fieldType: "TextInput",
    name: "publicationYear",
    label: "Publication year"
  },
  {
    fieldType: "TextInput",
    label: "Title",
    name: "title"
  },
  {
    fieldType: 'AutocompleteControl',
    name: "book",
    label: "In",
    source: '/api/autocomplete/book'
  },
  {
    fieldType: 'AutocompleteControl',
    name: "journal",
    label: "Journal",
    source: '/api/autocomplete/journal'
  },
  {
    fieldType: 'TextInput',
    name: "publisher",
    label: 'Publisher'
  },
  {
    fieldType: 'TextInput',
    name: "placeOfPublication",
    label: 'Place of publication'
  },
  {
    fieldType: 'TextInput',
    name: "volume",
    label: 'Volume',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: 'NumberInput',
    name: "issue",
    label: 'Issue',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: 'NumberInput',
    name: "number",
    label: 'Number',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: "NumberInput",
    name: "pageStart",
    label: "Page start",
    minValue: 0,
    controlWidth: 'col-md-2'
  },
  {
    fieldType: "NumberInput",
    name: "pageEnd",
    label: "Page end",
    minValue: 0,
    controlWidth: 'col-md-2'
  },
  {
    fieldType: 'TextInput',
    name: "pages",
    label: 'Pages',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: 'NumberInput',
    name: "numberOfPages",
    label: 'Number of pages',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: 'TextInput',
    name: "isbn",
    label: 'ISBN',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: 'TextInput',
    name: "issn",
    label: 'ISSN',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: 'TextInput',
    name: "doi",
    label: 'DOI',
    controlWidth: 'col-md-4'
  },
  {
    fieldType: "StaticControl",
    name: "citationHtml",
    label: "Citation"
  },
]
