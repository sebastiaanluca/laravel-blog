import slug from 'slug'

export default {
    mounted: function () {
        console.log('slug-input-field component loaded')
        
        this.bindSource()
    },
    
    props: [
        'read-from',
    ],
    
    data: function () {
        return {
            value: '',
            hasManualInput: false,
        }
    },
    
    methods: {
        onBlur: function () {
            this.value = this.slugify(this.value)
            
            this.hasManualInput = !!this.value
        },
        
        bindSource: function () {
            // Only when there's a source to watch
            if (this.readFrom === undefined) {
                return
            }
            
            $(this.readFrom).on('change keyup paste', this.updateFieldFromSource)
        },
        
        updateFieldFromSource: function () {
            if (this.hasManualInput) {
                return
            }
            
            this.value = this.slugify($(this.readFrom).val())
        },
        
        slugify: function (text) {
            return slug(text).toLowerCase()
        },
    },
}