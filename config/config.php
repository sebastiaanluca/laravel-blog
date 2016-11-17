<?php

return [
    
    /*
     * The base URL (without trailing slash and post slug) to a 
     * post's detail page. Adjust this depending on your own
     * blog post routing rules. Only used on the admin home page
     * to provide a direct link to the live post.
     */
    'public_post_base_url' => env('APP_URL', 'https://localhost'),
    
    /*
     * When enabled, the package will run all its default database 
     * migrations in addition to your application's migrations when 
     * running `php artisan migrate`. Set to false when you have 
     * published the package's migrations manually once to prevent
     * them from being executed twice.
     */
    'use_package_migrations' => true,

];