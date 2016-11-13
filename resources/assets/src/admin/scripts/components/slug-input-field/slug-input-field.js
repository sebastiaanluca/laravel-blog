import slug from 'slug'

export default {
    mounted: function () {
        console.log('slug-input-field component loaded')
    },
    
    data: function () {
        return {
            value: '',
        }
    },
    
    computed: {
        slug: function () {
            return slug(this.value)
        }
    },
    
    methods: {
        onBlur: function () {
            this.value = this.slug
        }
    },
}