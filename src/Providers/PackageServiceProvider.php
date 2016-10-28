<?php

namespace SebastiaanLuca\Blog\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use SebastiaanLuca\Helpers\Classes\ReflectionTrait;

// TODO: extract to laravel-packager
// TODO: check if directories/files exist before using them
abstract class PackageServiceProvider extends ServiceProvider
{
    use ReflectionTrait;
    
    /**
     * The lowercase package name without vendor.
     *
     * @var string
     */
    protected $package;
    
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->configure();
        $this->bindClasses();
        $this->registerCommands();
    }
    
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadResources();
        $this->registerPublishableResources();
        $this->bootMiddleware(app('Illuminate\Contracts\Http\Kernel'), app('router'));
        $this->mapRoutes();
    }
    
    /**
     * Automatically merge all user configuration settings for this package with the default ones (if missing).
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            $this->getClassDirectory() . '/../config/config.php', $this->package
        );
    }
    
    /**
     * Bind concrete repositories to their interfaces.
     */
    protected function bindClasses()
    {
        //
    }
    
    /**
     * Register artisan commands.
     */
    protected function registerCommands()
    {
        //
    }
    
    /**
     * Prepare all module assets.
     */
    protected function loadResources()
    {
        if (config('blog.use_package_migrations')) {
            $this->loadMigrationsFrom($this->getClassDirectory() . '/../database/migrations');
        }
        
        // TODO: test if user vendor blog translations override these (even selectively)
        $this->loadTranslationsFrom($this->getClassDirectory() . '/../resources/lang', $this->package);
        
        // TODO: test if user vendor blog views override these (even selectively)
        $this->loadViewsFrom($this->getClassDirectory() . '/../resources/views', $this->package);
    }
    
    /**
     * Register all publishable module assets.
     */
    protected function registerPublishableResources()
    {
        $this->publishes([
            $this->getClassDirectory() . '/../config/config.php' => config_path("{$this->package}.php"),
        ], 'config');
        
        $this->publishes([
            $this->getClassDirectory() . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');
        
        $this->publishes([
            $this->getClassDirectory() . '/../resources/lang' => resource_path("lang/vendor/{$this->package}"),
        ], 'translations');
        
        $this->publishes([
            $this->getClassDirectory() . '/../views' => resource_path("views/vendor/{$this->package}"),
        ], 'views');
        
        $this->publishes([
            $this->getClassDirectory() . '/../resources/assets/dist' => public_path("vendor/{$this->package}"),
        ], 'assets');
    }
    
    /**
     * Register package middleware.
     *
     * @param \Illuminate\Contracts\Http\Kernel $kernel
     * @param \Illuminate\Routing\Router $router
     */
    protected function bootMiddleware(Kernel $kernel, Router $router)
    {
        //
    }
    
    /**
     * Map out all module routes.
     */
    protected function mapRoutes()
    {
        //
    }
}