<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BlogPostInterface;

class BlogPostController extends Controller
{
    private $blog_post;

    public function __construct(BlogPostInterface $blog_post)
    {
        $this->blog_post = $blog_post;
    }

    public function index(Request $request)
    {
        return $this->blog_post->getAllBlogPosts($request);
    }
}
