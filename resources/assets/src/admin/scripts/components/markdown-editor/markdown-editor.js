import SimpleMDE from 'simplemde'

export default {
    mounted: function () {
        console.log('markdown-editor component loaded')
        
        this.saveInitialValue()
        this.loadEditor()
        this.loadSaveOptionButtons()
    },
    
    props: [
        'autosaveId',
    ],
    
    data: function () {
        return {
            initialValue: '',
            editor: null,
        }
    },
    
    methods: {
        saveInitialValue: function () {
            if (this.$slots.default) {
                this.initialValue = this.$slots.default[0].text
            }
        },
        
        loadEditor: function () {
            this.editor = new SimpleMDE({
                autosave: {
                    enabled: true,
                    delay: 5000,
                    uniqueId: 'markdown-editor-autosave-' + this.autosaveId,
                },
                blockStyles: {
                    bold: '__',
                    italic: '_'
                },
                forceSync: true,
                indentWithTabs: false,
                tabSize: 4,
                status: ['autosave', 'words'],
            })
        },
        
        loadSaveOptionButtons: function () {
            const discardChangesLink = `<a id="discard-changes-${this.autosaveId}" class="text-muted" href="#" title="Discard changes">discard changes</a>`
            
            $('.editor-statusbar .autosave').after(` (${discardChangesLink})`)
            
            $(`#discard-changes-${this.autosaveId}`).click((event, item) => {
                event.preventDefault()
                this.loadInitialValue()
            })
        },
        
        loadInitialValue: function () {
            this.editor.value(this.initialValue)
        },
    },
}