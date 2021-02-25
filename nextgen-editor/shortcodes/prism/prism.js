window.nextgenEditor.addShortcode('prism', {
  type: 'block',
  plugin: 'prism-highlight',
  title: 'Prism Highlight',
  button: {
    label: 'Prism Highlight',
    icon: '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke="#000" fill="none" stroke-linejoin="round"><path d="M8.03 12.5l3.984-12 3.984 12z"/><path d="M16.005 12.5l5.03-1.5L12.005.5"/><path d="M8.03 12.5L2.99 11 12.01.5M16.005 12.5l-3.984 11-3.984-11z"/><path d="M8.03 12.5L2.99 11l9.02 12.5"/><path d="M16.005 12.5l5.03-1.5-9.03 12.5"/></g><path fill="none" d="M0 0h24v24H0z"/></svg>',
  },
  attributes: {
    classes: {
      type: String,
      title: 'Classes',
      widget: 'input-text',
      default: '',
    },
    id: {
      type: String,
      title: 'ID',
      widget: 'input-text',
      default: '',
    },
    'cl-prompt': {
      type: String,
      title: 'CL Prompt',
      widget: 'input-text',
      default: '',
    },
    highlight: {
      type: String,
      title: 'Highlight',
      widget: 'input-text',
      default: '',
    },
    git: {
      type: String,
      title: 'Git URL',
      widget: 'input-text',
      default: '',
    },
  },
  titlebar({ attributes }) {
    return []
      .concat([
        attributes.classes ? `classes: <strong>${attributes.classes}</strong>` : null,
        attributes.git ? `git: <strong>${attributes.git}</strong>` : null,
      ])
      .filter((item) => !!item)
      .join(', ');
  },
  content({ attributes }) {
    return `<pre><code>{{content_editable}}</code></pre>`
  },
});

