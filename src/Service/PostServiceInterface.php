<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\Data\PostData;

interface PostServiceInterface
{
    public function savePost(string $title, string $subtitle, string $content, ?string $imagePath): int;
    
    public function getPost(int $postId): PostData;

    public function deletePost(int $postId): void;

    public function listPosts(): array;
}