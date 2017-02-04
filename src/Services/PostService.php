<?php

namespace SebastiaanLuca\Blog\Services;

use Illuminate\Support\Collection;
use League\CommonMark\Converter;
use SebastiaanLuca\Blog\Models\Post;

class PostService
{
    /**
     * @var \SebastiaanLuca\Blog\Models\Post
     */
    protected $posts;

    /**
     * @var \League\CommonMark\Converter
     */
    protected $markdown;

    /**
     * PostService constructor.
     *
     * @param \SebastiaanLuca\Blog\Models\Post $posts
     * @param \League\CommonMark\Converter $markdown
     */
    public function __construct(Post $posts, Converter $markdown)
    {
        $this->posts = $posts;
        $this->markdown = $markdown;
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
            $columns = $this->getDefaultIndexColumns();
        }

        $posts = $this->posts->published()->orderChronologically()->get($columns);

        $posts = $this->preparePostIntros($posts);

        return $posts;
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
        $post = $this->posts->published()->where('slug', $slug)->firstOrFail();

        $post = $this->removeIntroTagFromPostBody($post);
        $post->body = $this->parseMarkdown($post->body);

        return $post;
    }

    /**
     * Get an array of columns to use when retrieving a list of posts for the index.
     *
     * @return array
     */
    protected function getDefaultIndexColumns() : array
    {
        return [
            'id',
            'slug',
            'title',
            'intro',
            'body',
            'published_at',
        ];
    }

    /**
     * Compute and render the intro of a set of given posts.
     *
     * @param \Illuminate\Support\Collection $posts
     *
     * @return \Illuminate\Support\Collection
     */
    protected function preparePostIntros(Collection $posts) : Collection
    {
        return $posts->map(function (Post $post) {
            // Compute intro
            if (is_null($post->intro)) {
                $post->intro = str_limit($post->body, 300);
            }

            // Parse intro
            $post->intro = $this->parseMarkdown($post->intro);

            return $post;
        });
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

    /**
     * Parse the post's Markdown body.
     *
     * @param string $content
     *
     * @return string
     */
    protected function parseMarkdown(string $content) : string
    {
        return $this->markdown->convertToHtml($content);
    }
}
