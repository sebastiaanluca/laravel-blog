<?php

namespace SebastiaanLuca\Blog\Providers;

use SebastiaanLuca\Blog\Http\Routers\AdminRouter;
use SebastiaanLuca\Blog\Http\Routers\PublicRouter;

class BlogServiceProvider extends PackageServiceProvider
{
    /**
     * The lowercase package name without vendor.
     *
     * @var string
     */
    protected $package = 'blog';
    
    /**
     * Map out all module routes.
     */
    protected function mapRoutes()
    {
        app(AdminRouter::class);
        app(PublicRouter::class);
    }
}