<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface BlogPostInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface BlogPostInterface extends PrettusInterface
{   
    public function getAllBlogPosts($request);
}
