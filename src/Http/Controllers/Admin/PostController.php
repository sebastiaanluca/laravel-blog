<?php

namespace SebastiaanLuca\Blog\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use SebastiaanLuca\Blog\Http\Validators\PostStoreValidator;
use SebastiaanLuca\Blog\Http\Validators\PostUpdateValidator;
use SebastiaanLuca\Blog\Models\Post;

class PostController extends Controller
{
    /**
     * @var \SebastiaanLuca\Blog\Models\Post
     */
    protected $posts;
    
    /**
     * PostController constructor.
     *
     * @param \SebastiaanLuca\Blog\Models\Post $posts
     */
    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $posts = $this->posts->orderBy('published_at', 'DESC')->get();
        
        return view('blog::admin/pages/posts/index', compact('posts'));
    }
    
    /**
     * Show the view for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        return view('blog::admin/pages/posts/create');
    }
    
    /**
     * Create a new resource.
     *
     * @param \SebastiaanLuca\Blog\Http\Validators\PostStoreValidator $validator
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostStoreValidator $validator) : RedirectResponse
    {
        $input = $validator->valid();
        $input['intro'] = $this->getIntroBlock($input['body']);
        $input['published_at'] = $this->getPublishedAtDate($input['published_at']);
        
        $this->posts->create($input);
        
        return redirect()->route('blog::admin.posts.index');
    }
    
    /**
     * View a resource.
     *
     * @param string $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $id) : View
    {
        $post = $this->posts->findOrFail($id);
        
        return view('blog::admin/pages/posts/show', compact('post'));
    }
    
    /**
     * Show the view for editing the given resource.
     *
     * @param string $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(string $id) : View
    {
        $post = $this->posts->findOrFail($id);
        
        return view('blog::admin/pages/posts/edit', compact('post'));
    }
    
    /**
     * Update the given resource.
     *
     * @param \SebastiaanLuca\Blog\Http\Validators\PostUpdateValidator $validator
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateValidator $validator, string $id) : RedirectResponse
    {
        // TODO: refactor to use repository (with exception throwing instead of returning a boolean)
        $post = $this->posts->findOrFail($id);
        
        $input = $validator->valid();
        $input['intro'] = $this->getIntroBlock($input['body']);
        $input['published_at'] = $this->getPublishedAtDate($input['published_at']);
        
        $post->update($input);
        
        return redirect()->route('blog::admin.posts.index');
    }
    
    /**
     * Delete the given resource.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id) : RedirectResponse
    {
        $this->posts->delete($id);
        
        return redirect()->route('blog::admin.posts.index');
    }
    
    /**
     * Get a post's intro block from its body.
     *
     * @param string $body
     * @param string $mark
     *
     * @return string|null
     */
    protected function getIntroBlock($body, $mark = '[endintro]')
    {
        $intro = trim(strstr($body, $mark, true));
        
        if (! $intro) {
            return null;
        }
        
        return $intro;
    }
    
    /**
     * Get a valid publish date.
     *
     * @param string $date
     *
     * @return string
     */
    protected function getPublishedAtDate(string $date) : string
    {
        $date = ! $date ? Carbon::now() : Carbon::createFromFormat('d/m/Y', $date);
        
        $date = $date->setTime(0, 0, 0);
        
        return $date;
    }
}