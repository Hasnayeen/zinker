import Alpine from 'alpinejs'
import Split from 'split-grid'
import { EditorView, lineNumbers, keymap } from '@codemirror/view'
import { EditorState } from '@codemirror/state'
import { php, phpLanguage } from '@codemirror/lang-php'
import { autocompletion } from '@codemirror/autocomplete'
import { defaultKeymap, history, historyKeymap } from '@codemirror/commands'
import { nord } from 'cm6-theme-nord'

window.Alpine = Alpine

Alpine.data('app', () => ({
  windowWidth: window.innerWidth,
  gutterWidth: 9,
  minSize: 100,
  breakpoint: 768,
  editor: null,
  value: null,

//======================================================================
// Methods
//======================================================================

  init () {
    this.initSplit()
    this.$watch('needsColumnLayout', () => {this.initSplit()})
    window.addEventListener('resize', () => {
      this.windowWidth = window.innerWidth
    })
    this.initEditor()
  },

  initEditor () {
    this.editor = new EditorView({
      state: EditorState.create({
        doc: '',
        extensions: [
          lineNumbers(),
          EditorView.lineWrapping,
          php({baseLanguage: phpLanguage, plain: true}),
          autocompletion(),
          nord,
          history(),
          keymap.of([
            { key: "Ctrl-Enter", run: () => this.executeCode() },
            ...defaultKeymap,
            ...historyKeymap,
          ])
        ],
      }),
      parent: document.getElementById('editor')
    })
    this.editor.focus()
  },

  initSplit () {
    this.destroySplit()

    this.split = Split({
      [this.needsColumnLayout ? 'columnGutters' : 'rowGutters']: [
        {
          track: 1,
          element: document.getElementById('gutter'),
        },
      ],
      minSize: this.minSize,
    })
  },

  destroySplit () {
    if (this.split) {
      this.split.destroy()
    }
  },

  switchProject(project) {
    console.log(this.currentProject)
    window.Livewire.first().call('switchProject', project.id)
    this.currentProject = project
    console.log(this.currentProject)
  },

  executeCode () {
    window.Livewire.first().call('execute', this.editor.state.doc)
    return true
  },

//======================================================================
// Computed Methods
//======================================================================

  get columnPercentage() {
    return ((1 - this.gutterWidth / window.innerWidth) / 2) * 100 + '%'
  },

  get rowPercentage() {
    return ((1 - this.gutterWidth / window.innerHeight) / 2) * 100 + '%'
  },

  get needsColumnLayout() {
    return this.windowWidth > this.breakpoint
  },

  get gridStyle() {
    if (this.needsColumnLayout) {
      return {
        gridTemplateColumns: `${this.columnPercentage} ${this.gutterWidth}px ${this.columnPercentage}`,
      }
    }

    return {
      gridTemplateRows: `${this.rowPercentage} ${this.gutterWidth}px ${this.rowPercentage}`,
    }
  },

}))


Alpine.start()
