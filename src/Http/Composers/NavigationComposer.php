<?php

namespace SebastiaanLuca\Blog\Http\Composers;

use Illuminate\View\View;
use SebastiaanLuca\Blog\Models\Post;

class NavigationComposer
{
    /**
     * @var \SebastiaanLuca\Blog\Models\Post
     */
    protected $posts;
    
    /**
     * NavigationComposer constructor.
     *
     * @param \SebastiaanLuca\Blog\Models\Post $posts
     */
    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }
    
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {
        $view->with('totalPostCount', $this->posts->count());
    }
}