import 'font-awesome/scss/font-awesome.scss'
import '../styles/admin.scss'
import 'bootstrap'
import 'bootstrap-datepicker'
import Vue from 'vue'

//

new Vue({
    created: function () {
        console.log('admin module loaded')
        
        this.initPopOvers()
        this.initDateInputFields()
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
                });
            })
        }
    }
})