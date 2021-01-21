<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;

interface PostServiceInterface
{
    /**
     * @return Post[]
     */
    public function getAllPosts(): array;

    /**
     * @param int $postId
     * @return Post
     */
    public function getPost(int $postId): Post;
}
