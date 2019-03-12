<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\BlogPostInterface;
use App\Models\BlogPost;
use App\Models\BlogPostCategories;
use App\Models\SiteTree;

/**
 * Class BlogPostRepository.
 *
 * @package namespace App\Repositories;
 */
class BlogPostRepository extends BaseRepository implements BlogPostInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BlogPost::class;
    }

    /**
     * Get All Blog Posts
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function getAllBlogPosts($request)
    {   
        $uri = $request->uri;
        if ($uri === 'resources') {
            $blog_post = BlogPost::with('file')
                        ->with('detail')
                        ->with('categories.category')
                        ->paginate(20);
            return $blog_post;
        }  
        
        $blog_post_category = $this->getBlogPostCategory($uri);
        $blog_post = BlogPostCategories::where('BlogPostCategoryID', $blog_post_category)
                                            ->with('blogs.file')
                                            ->with('blogs.detail')
                                            ->with('category')
                                            ->paginate(20);
        return $blog_post;

    }   

    /**
     * Get Blog Post Category
     *
     * @param [string] $uri
     * @return Integer
     */
    private function getBlogPostCategory($uri)
    {   
        $blog_post_category = 0;
        switch ($uri) {
            case 'employee advice':
                $blog_post_category = 3;
            break;
            case 'employer advice':
                $blog_post_category = 4;
            break;
            case 'video':
                $blog_post_category = 5;
            break;
            case 'news':
                $blog_post_category = 6;
            break;
            case 'human resources':
                $blog_post_category = 7;
            break;
            case 'video interview tips':
                $blog_post_category = 8;
            break;
            case 'profile video examples':
                $blog_post_category = 9;
            break;
        }

        return $blog_post_category;
    }

    /**
     * Get Blog Posts Details
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function getDetails($request)
    {
        $blog_post = SiteTree::where('URLSegment', $request->slug_name)
                                ->with('blog.file')
                                ->with('blog.categories.category')
                                ->first();

        $blog_post->widget = $this->getWidget($blog_post->ID);
        return $blog_post;
    }

    /**
     * Get Widget
     *
     * @param [integer] $id
     * @return \Illuminate\Eloquent\Collection
     */
    private function getWidget($id)
    {
        $widget = SiteTree::where('ID', '>', $id)
                                ->with('blog.file')
                                ->with('blog.categories.category')
                                ->take(3)
                                ->get();

        return $widget;
    }

}
