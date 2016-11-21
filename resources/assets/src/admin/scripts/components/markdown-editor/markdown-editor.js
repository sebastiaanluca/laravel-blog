// TODO: optimize (~300KB now)
import SimpleMDE from 'simplemde'

export default {
    mounted: function () {
        this.loadEditor()
    },
    
    data: function () {
        return {
            editor: null,
        }
    },
    
    methods: {
        loadEditor: function () {
            this.editor = new SimpleMDE({
                element: this.$el,
                blockStyles: {
                    bold: '__',
                    italic: '_'
                },
                forceSync: true,
                indentWithTabs: false,
                tabSize: 4,
                status: false,
            })
        },
    },
}