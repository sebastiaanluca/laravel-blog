<?php

namespace SebastiaanLuca\Blog\Http\Validators;

use Illuminate\Validation\Rule;
use SebastiaanLuca\Validator\Validators\Validator;

class PostStoreValidator extends Validator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'title' => 'required|string|max:180',
            'slug' => ['required', 'string', 'alpha_dash', 'max:180', Rule::unique('blog_posts')->where('deleted_at', 'NULL')],
            'body' => 'required|string|max:16383',
            'is_draft' => 'required|boolean',
            'published_at' => 'date_format:Y-m-d H:i:s',
        ];
    }
}