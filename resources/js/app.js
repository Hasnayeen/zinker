import Alpine from 'alpinejs'
import focus from "@alpinejs/focus"
import Split from 'split-grid'
import { EditorView, lineNumbers, keymap } from '@codemirror/view'
import { EditorState } from '@codemirror/state'
import { php, phpLanguage } from '@codemirror/lang-php'
import { autocompletion } from '@codemirror/autocomplete'
import { defaultKeymap, history, historyKeymap } from '@codemirror/commands'
import { nord } from 'cm6-theme-nord'

Alpine.plugin(focus)

window.Alpine = Alpine

Alpine.data('app', () => ({
  windowWidth: window.innerWidth,
  gutterWidth: 9,
  minSize: 100,
  breakpoint: 768,
  editor: null,
  value: null,
  commands: [],
  focusedCommand: null,

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
    window.Livewire.emitTo('command-palette', 'updateCommandList')
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
            { key: "Ctrl-Shift-/", run: () => this.openCommandPalette() },
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

  switchProject (project) {
    window.Livewire.first().call('switchProject', project.id)
    this.currentProject = project
  },

  executeCode () {
    window.Livewire.first().call('execute', this.editor.state.doc)
    return true
  },

  openCommandPalette() {
    if (event.target.contains(document.activeElement) && !event.shiftKey) {
      return false
    }
    window.Livewire.emitTo('command-palette', 'showCommandPalette')
  },

  updateCommandList (e) {
    this.commands = e.detail
  },

//======================================================================
// Computed Methods
//======================================================================

  get columnPercentage () {
    return ((1 - this.gutterWidth / window.innerWidth) / 2) * 100 + '%'
  },

  get rowPercentage () {
    return ((1 - this.gutterWidth / window.innerHeight) / 2) * 100 + '%'
  },

  get needsColumnLayout () {
    return this.windowWidth > this.breakpoint
  },

  get gridStyle () {
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
