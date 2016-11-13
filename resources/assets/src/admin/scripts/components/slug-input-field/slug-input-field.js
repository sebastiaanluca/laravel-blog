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
            //            return this.value.split('').reverse().join('')
            
            //            const trimmed = $.trim(str);
            //            
            //            const slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            //            
            //            replace(/-+/g, '-').
            //            replace(/^-|-$/g, '');
            
            //            const slug = trim(this.value)
            //            
            //            return slug.toLowerCase()
            
            return slug(this.value)
        }
    },
    
    methods: {
        onBlur: function () {
            this.value = this.slug
        }
    },
}