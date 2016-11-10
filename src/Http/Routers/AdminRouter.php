<?php

namespace SebastiaanLuca\Blog\Http\Routers;

use SebastiaanLuca\Blog\Http\Controllers\Admin\PostController;
use SebastiaanLuca\Router\Routers\Router;

class AdminRouter extends Router
{
    /**
     * Map the routes.
     */
    public function map()
    {
        // TODO: protect using auth middleware
        $this->router->group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'web'], function() {
            $this->router->get('/', [
                'as' => 'home', function() {
                    return redirect()->route('admin.posts.index');
                }
            ]);
            
            $this->router->resource('posts', PostController::class);
        });
    }
}