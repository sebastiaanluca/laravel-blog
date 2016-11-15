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
    
    /**
     * Get a published post by its slug.
     *
     * @param string $slug
     *
     * @return \SebastiaanLuca\Blog\Models\Post
     */
    public function getPublishedPostBySlug(string $slug) : Post
    {
        // TODO: parse MarkDown
        
        $post = $this->posts->published()->where('slug', $slug)->firstOrFail();
        
        $post = $this->removeIntroTagFromPostBody($post);
        
        return $post;
    }
    
    /**
     * Remove the intro tag from the post's body.
     *
     * @param \SebastiaanLuca\Blog\Models\Post $post
     *
     * @return \SebastiaanLuca\Blog\Models\Post
     */
    protected function removeIntroTagFromPostBody(Post $post) : Post
    {
        $post->body = str_replace('[endintro]', '', $post->body);
        
        return $post;
    }
}