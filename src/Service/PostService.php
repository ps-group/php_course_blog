<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;
use App\Service\Data\PostData;
use App\Repository\PostRepository;

class PostService implements PostServiceInterface
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function savePost(string $title, string $subtitle, string $content, ?string $imagePath): int
    {
        $post = new Post(
            null,
            $title,
            $subtitle,
            $content,
            $imagePath,
            new \DateTimeImmutable(),
        );
        return $this->postRepository->store($post);
    }

    public function getPost(int $postId): PostData
    {
        $post = $this->postRepository->findById($postId);
        if ($post === null)
        {
            throw $this->createNotFoundException();
        }

        return new PostData(
            $post->getId(),
            $post->getTitle(),
            $post->getSubtitle(),
            $post->getContent(),
            $post->getImagePath(),
            $post->getPostedAt(),
        );
    }

    public function deletePost(int $postId): void
    {
        $post = $this->postRepository->findById($postId);
        if ($post === null)
        {
            throw $this->createNotFoundException();
        }

        $this->postRepository->delete($post);
    }

    public function listPosts(): array
    {
        $posts = $this->postRepository->listAll();

        $postsView = [];
        foreach ($posts as $post)
        {
            $postsView[] = new PostData(
                $post->getId(),
                $post->getTitle(),
                $post->getSubtitle(),
                $post->getContent(),
                $post->getImagePath(),
                $post->getPostedAt(),
            );
        }

        return  $postsView;
    }
}