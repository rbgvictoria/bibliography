export default [
  {
    fieldType: "SelectList",
    name: "agentType",
    multi: false,
    label: "Agent type",
    options: [
      { value: 'Person', label: 'Person' },
      { value: 'Group', label: 'Group' },
      { value: 'Organization', label: 'Organization' }
    ]
  },
  {
    fieldType: "TextInput",
    name: "name",
    label: "Name"
  },
  {
    fieldType: "TextInput",
    name: "firstName",
    label: "First name",
  },
  {
    fieldType: "TextInput",
    name: "lastName",
    label: "Last name"
  },
  {
    fieldType: "TextInput",
    label: "initials",
    name: "Initials"
  }
]
