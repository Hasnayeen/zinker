import Alpine from 'alpinejs'
import focus from "@alpinejs/focus"
import Split from 'split-grid'
import { EditorView, lineNumbers, keymap, placeholder } from '@codemirror/view'
import { EditorState, Compartment } from '@codemirror/state'
import { php, phpLanguage } from '@codemirror/lang-php'
import { indentUnit, syntaxHighlighting } from "@codemirror/language"
import { autocompletion } from '@codemirror/autocomplete'
import { defaultKeymap, history, historyKeymap } from '@codemirror/commands'
import { nord, gruvboxLight, gruvboxDark, solarizedLight, solarizedDark, materialDark } from './theme.js'
import { nordHighlightStyle } from 'cm6-theme-nord'

Alpine.plugin(focus)

window.Alpine = Alpine

Alpine.data('app', () => ({
  windowWidth: window.innerWidth,
  gutterWidth: 9,
  minSize: 100,
  breakpoint: 768,
  currentLayout: 'column',
  editor: null,
  value: null,
  commands: [],
  focusedCommand: null,
  theme: null,
  currentTheme: null,
  themes: null,

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

  initEditor() {
    this.theme = new Compartment
    this.themes = [nord, gruvboxLight, gruvboxDark, solarizedLight, solarizedDark, materialDark]
    let currentTheme = nord
    this.currentTheme = currentTheme
    this.editor = new EditorView({
      state: EditorState.create({
        doc: '',
        extensions: [
          placeholder(`To run code click the run button or press (Ctrl+Enter)
To open the command palette press (Ctrl+/) or (Ctrl+Shift+/)
To open the DateTime formatter press (Ctrl+Shift+f)
To change editor theme press (Ctrl+Alt+s)`),
          lineNumbers(),
          EditorView.lineWrapping,
          indentUnit.of("    "),
          php({baseLanguage: phpLanguage, plain: true}),
          autocompletion(),
          this.theme.of(currentTheme),
          syntaxHighlighting(nordHighlightStyle),
          history(),
          keymap.of([
            { key: "Ctrl-Enter", run: () => this.executeCode() },
            { key: "Ctrl-Shift-/", run: () => this.openCommandPalette() },
            { key: "Ctrl-Shift-f", run: () => this.openCommandPalette('DateTime Format') },
            { key: "Ctrl-Alt-s", run: () => this.switchEditorTheme() },
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

  executeCode() {
    window.Livewire.first().call('execute', this.editor.state.doc)
    return true
  },

  openCommandPalette (commandName = null) {
    if (event.target.contains(document.activeElement) && !event.shiftKey) {
      return false
    }
    window.Livewire.emitTo('command-palette', 'showCommandPalette', commandName)
  },

  openSettings () {
    window.Livewire.emitTo('settings', 'show')
  },

  updateCommandList (e) {
    this.commands = e.detail
  },

  switchEditorTheme (theme) {
    const currentIndex = this.themes.indexOf(this.currentTheme)
    const nextIndex = (currentIndex + 1) % this.themes.length
    this.currentTheme = this.themes[nextIndex]
    this.editor.dispatch({
      effects: this.theme.reconfigure(this.themes[nextIndex])
    })
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
    return (this.windowWidth > this.breakpoint) && (this.currentLayout === 'column')
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
