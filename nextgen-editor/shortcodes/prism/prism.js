window.nextgenEditor.addShortcode('prism', {
  type: 'block',
  plugin: 'prism-highlight',
  title: 'Prism Highlight',
  button: {
    label: 'Prism Highlight',
    icon: '<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="95.76" height="95.6" viewBox="0 0 47.88 47.8"><path d="M47.511 15.68L24.748 47.422l-.003.003a.987.987 0 01-.399.315.977.977 0 01-.408.099.977.977 0 01-.408-.099.987.987 0 01-.399-.315l-.004-.003L.364 15.68a.982.982 0 01-.367-.755c0-.006.003-.01.003-.015-.002-.025.014-.048.015-.073a.983.983 0 01.071-.317c.018-.05.008-.105.034-.153L7.768.479c.01-.017.03-.025.04-.042A.976.976 0 018.209.08c.041-.02.073-.052.117-.067.078-.026.156-.022.234-.029.029-.002.052-.022.082-.022h30.59c.03 0 .053.02.082.022.078.007.156.003.234.029.044.015.076.047.116.067a.976.976 0 01.402.357c.01.017.03.025.04.042l7.649 13.888c.027.048.017.103.035.153.044.099.063.21.073.323 0 .023.014.044.013.067 0 .005.003.009.003.015a.98.98 0 01-.368.755zm-2.628.242h-9.587l-8.327 24.98 17.914-24.98zM23.938 2.584l-8.823 11.343h17.646L23.938 2.584zm0 41.104l9.256-27.766H14.681l9.257 27.766zm-3.032-2.786l-8.327-24.98H2.992l17.914 24.98zM8.306 3.106L2.62 13.927h9.293L8.306 3.106zm1.7-1.207l3.581 10.743 8.356-10.743H10.006zm15.926 0l8.356 10.742 3.58-10.742H25.932zM39.57 3.1l-3.609 10.827h9.296L39.57 3.1z" fill-rule="evenodd"/></svg>',
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
    return `<div class="sc-prism">{{content_editable}}</div>`
  },
});

