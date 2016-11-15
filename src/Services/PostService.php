<?php

namespace SebastiaanLuca\Blog\Services;

use Illuminate\Support\Collection;
use SebastiaanLuca\Blog\Models\Post;

class PostService
{
    /**
     * @var \SebastiaanLuca\Blog\Models\Post
     */
    protected $posts;
    
    /**
     * PostService constructor.
     *
     * @param \SebastiaanLuca\Blog\Models\Post $posts
     */
    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }
    
    /**
     * Get a chronological list of published posts.
     *
     * @param array|null $columns
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPublishedPosts($columns = null) : Collection
    {
        if (is_null($columns)) {
            $columns = [
                'id',
                'slug',
                'title',
                'intro',
                'published_at',
            ];
        }
        
        return $this->posts->published()->orderChronologically()->get($columns);
    }
}