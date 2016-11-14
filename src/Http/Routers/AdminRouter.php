<?php

namespace SebastiaanLuca\Blog\Http\Routers;

use SebastiaanLuca\Blog\Http\Controllers\Admin\Auth\LoginController;
use SebastiaanLuca\Blog\Http\Controllers\Admin\PostController;
use SebastiaanLuca\Router\Routers\Router;

class AdminRouter extends Router
{
    /**
     * Map the routes.
     */
    public function map()
    {
        $this->router->group(['prefix' => 'admin', 'as' => 'blog::admin.', 'middleware' => 'web'], function() {
            $this->router->get('login', ['as' => 'auth.login', 'uses' => LoginController::class . '@showLoginForm']);
            $this->router->post('login', ['as' => 'auth.login.post', 'uses' => LoginController::class . '@login']);
            $this->router->post('logout', ['as' => 'auth.logout.post', 'uses' => LoginController::class . '@logout']);
        });
        
        $this->router->group(['prefix' => 'admin', 'as' => 'blog::admin.', 'middleware' => ['web', 'auth']], function() {
            $this->router->get('/', [
                'as' => 'home', function() {
                    return redirect()->route('blog::admin.posts.index');
                }
            ]);
            
            $this->router->resource('posts', PostController::class);
        });
    }
}