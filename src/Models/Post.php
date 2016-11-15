<?php

namespace SebastiaanLuca\Blog\Models;

use Carbon\Carbon;
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
    
    /**
     * Scope a query to only include published posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_draft', false)->where('published_at', '<=', Carbon::now());
    }
    
    /**
     * Scope a query to order in reverse chronological order.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderChronologically($query)
    {
        return $query->orderBy('published_at', 'DESC');
    }
}