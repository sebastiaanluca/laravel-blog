<?php

namespace SebastiaanLuca\Blog;

use SebastiaanLuca\Blog\Providers\PackageServiceProvider;

class BlogServiceProvider extends PackageServiceProvider
{
    /**
     * The lowercase package name without vendor.
     *
     * @var string
     */
    protected $package = 'blog';
}
