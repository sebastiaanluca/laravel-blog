<?php

namespace SebastiaanLuca\Blog\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SebastiaanLuca\Blog\Http\Validators\PostStoreValidator;
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
        $posts = $this->posts->all();
        
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
        
        $endIntroMark = '[endintro]';
        $input['intro'] = strstr($input['body'], $endIntroMark, true);
        
        $this->posts->create($input);
        
        return redirect()->route('admin.posts.index');
    }
    
    /**
     * View a resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, string $id) : View
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
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateValidator $validator, string $id) : RedirectResponse
    {
        $input = $validator->valid();
        
        $this->posts->update($id, $input);
        
        return redirect()->route('posts.show', $id);
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
        
        return redirect()->route('posts.index');
    }
}