import 'font-awesome/scss/font-awesome.scss'
import '../styles/admin.scss'
import 'bootstrap'
import 'bootstrap-datepicker'
import Vue from 'vue'
import SlugInputField from './components/slug-input-field/slug-input-field.vue'
import MarkdownEditor from './components/markdown-editor/markdown-editor.vue'

//

Vue.component('SlugInputField', SlugInputField)
Vue.component('MarkdownEditor', MarkdownEditor)

new Vue({
    el: '#blog-admin',
    
    mounted: function () {
        this.initPopOvers()
        this.initDateInputFields()
    },
    
    methods: {
        initPopOvers: function () {
            $(function () {
                $('[data-toggle="popover"]').popover()
            })
        },
        
        // TODO: move to Vue component
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
    }
})