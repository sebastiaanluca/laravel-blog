<?php

namespace SebastiaanLuca\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_posts';
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [''];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_draft' => 'boolean',
    ];
    
    /**
     * The attributes that should be cast to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];
}