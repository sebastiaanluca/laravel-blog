<?php

namespace SebastiaanLuca\Blog\Providers;

use Illuminate\Support\Facades\View;
use SebastiaanLuca\Blog\Http\Composers\NavigationComposer;
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
     * Bootstrap the application services.
     */
    public function boot()
    {
        parent::boot();
        
        $this->registerViewComposers();
    }
    
    /**
     * Map out all module routes.
     */
    protected function mapRoutes()
    {
        app(AdminRouter::class);
        app(PublicRouter::class);
    }
    
    /**
     * Register package view composers.
     */
    protected function registerViewComposers()
    {
        View::composer('blog::admin/partials/navigation', NavigationComposer::class);
    }
}