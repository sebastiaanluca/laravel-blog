import 'font-awesome/scss/font-awesome.scss'
import '../styles/admin.scss'
import 'bootstrap'
import 'bootstrap-datepicker'
import SimpleMDE from 'simplemde'
import 'simplemde/debug/simplemde.css'
import Vue from 'vue'

//

new Vue({
    created: function () {
        console.log('admin module loaded')
        
        this.initPopOvers()
        this.initDateInputFields()
        this.initTextEditors()
    },
    methods: {
        initPopOvers: function () {
            $(function () {
                $('[data-toggle="popover"]').popover()
            })
        },
        
        initDateInputFields: function () {
            $('input.input-date').each(function () {
                const locale = $(this).data('locale')
                
                $(this).datepicker({
                    language: locale,
                    format: $(this).data('date-format'),
                    weekStart: locale == 'en' ? 0 : 1,
                    maxViewMode: 1,
                    todayBtn: 'linked',
                    orientation: 'bottom auto',
                    autoclose: true,
                    todayHighlight: true,
                })
            })
        },
        
        initTextEditors: function () {
            $('.text-editor').each(function () {
                const editorId = 'simplemde-editor-' + $(this).data('id')
                
                new SimpleMDE({
                    element: $(this)[0],
                    autosave: {
                        enabled: true,
                        delay: 5000,
                        uniqueId: editorId,
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
            })
        }
    }
})