<?php

namespace SebastiaanLuca\Blog\Providers;

use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use SebastiaanLuca\Blog\Http\Composers\NavigationComposer;
use SebastiaanLuca\Blog\Http\Middleware\RedirectIfAuthenticated;
use SebastiaanLuca\Blog\Http\Middleware\RedirectIfGuest;
use SebastiaanLuca\Blog\Http\Routers\AdminRouter;
use SebastiaanLuca\Helpers\Html\HtmlServiceProvider;
use SebastiaanLuca\Helpers\Methods\GlobalMethodsServiceProvider;
use SebastiaanLuca\Router\RouterServiceProvider;

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
     * Register additional service providers.
     */
    protected function registerProviders()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(GlobalMethodsServiceProvider::class);
        $this->app->register(HtmlServiceProvider::class);
        $this->app->register(MarkdownServiceProvider::class);
    }

    /**
     * Register all publishable module assets.
     */
    protected function registerPublishableResources()
    {
        parent::registerPublishableResources();

        $this->publishes([
            $this->getPackageDirectory() . '/resources/assets/src' => resource_path("assets/vendor/{$this->package}"),
        ], 'source');
    }

    /**
     * Register package middleware.
     *
     * @param \Illuminate\Contracts\Http\Kernel $kernel
     * @param \Illuminate\Routing\Router $router
     */
    protected function bootMiddleware(Kernel $kernel, Router $router)
    {
        $router->aliasMiddleware('blog.auth', RedirectIfGuest::class);
        $router->aliasMiddleware('blog.guest', RedirectIfAuthenticated::class);
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
