<?php

namespace SebastiaanLuca\Blog\Http\Validators;

use Illuminate\Validation\Rule;
use SebastiaanLuca\Validator\Validators\Validator;

class PostUpdateValidator extends Validator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'title' => 'string|max:180',
            'slug' => ['string', 'alpha_dash','max:180', Rule::unique('blog_posts')->where('deleted_at', 'NULL')->ignore($this->post)],
            'body' => 'string|max:4194303',
            'is_draft' => 'boolean',
            'published_at' => 'date_format:d/m/Y',
        ];
    }
}