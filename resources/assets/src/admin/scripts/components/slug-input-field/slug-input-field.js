import slug from 'slug'

export default {
    mounted: function () {
        this.setDefaults()
        this.bindSource()
    },
    
    props: [
        'read-from',
    ],
    
    data: function () {
        return {
            value: null,
            hasManualInput: false,
        }
    },
    
    methods: {
        setDefaults: function () {
            this.value = this.$el.value
            this.hasManualInput = ! ! this.$el.value
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
        
        onBlur: function () {
            this.value = this.slugify(this.value)
            
            this.hasManualInput = ! ! this.value
            
            // Set from source
            if (this.readFrom && ! this.hasManualInput) {
                this.updateFieldFromSource()
            }
        },
    },
}
