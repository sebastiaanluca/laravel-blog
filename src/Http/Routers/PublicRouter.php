<?php

namespace SebastiaanLuca\Blog\Http\Routers;

use SebastiaanLuca\Router\Routers\Router;

class PublicRouter extends Router
{
    /**
     * Map the routes.
     */
    public function map()
    {
        $this->router->group(['as' => 'public.', 'middleware' => 'web'], function() {
            $this->router->get('/', function() {
                return 'hi';
            });
        });
    }
}