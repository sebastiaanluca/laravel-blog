<?php

namespace SebastiaanLuca\Blog\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use SebastiaanLuca\Blog\Http\Composers\NavigationComposer;
use SebastiaanLuca\Blog\Http\Middleware\RedirectIfAuthenticated;
use SebastiaanLuca\Blog\Http\Middleware\RedirectIfGuest;
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
     * Register package middleware.
     *
     * @param \Illuminate\Contracts\Http\Kernel $kernel
     * @param \Illuminate\Routing\Router $router
     */
    protected function bootMiddleware(Kernel $kernel, Router $router)
    {
        $router->middleware('blog.auth', RedirectIfGuest::class);
        $router->middleware('blog.guest', RedirectIfAuthenticated::class);
    }
    
    /**
     * Map out all module routes.
     */
    protected function mapRoutes()
    {
        app(AdminRouter::class);
    }
    
    /**
     * Register package view composers.
     */
    protected function registerViewComposers()
    {
        View::composer('blog::admin/partials/navigation', NavigationComposer::class);
    }
}