<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;
use App\Repository\UserRepository;
use App\Service\Data\PostData;
use App\Repository\PostRepository;

class PostService
{
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function createPost(string $title, string $subtitle, string $content, ?string $imagePath, int $author): int
    {
        $post = new Post(
            null,
            $title,
            $subtitle,
            $content,
            $imagePath,
            $author,
            new \DateTimeImmutable()
        );
        return $this->postRepository->store($post);
    }

    public function getPost(int $postId): ?PostData
    {
        $post = $this->postRepository->findById($postId);
        $author = $post->getAuthor();
        $authorEmail = null;
        if ($author !== null)
        {
            $user = $this->userRepository->findById($author);
            $authorEmail = $user ? $user->getEmail() : null;
        }
        return ($post === null) ? null : new PostData(
            $post->getId(),
            $post->getTitle(),
            $post->getSubtitle(),
            $post->getContent(),
            $post->getImagePath(),
            $post->getAuthor(),
            $authorEmail,
            $post->getPostedAt(),
        );
    }

    public function deletePost(int $postId): void
    {
        $post = $this->postRepository->findById($postId);
        if ($post === null)
        {
            return;
        }

        $this->postRepository->delete($post);
    }

    public function listPosts(): array
    {
        $posts = $this->postRepository->listAll();
        $userIds = [];
        foreach ($posts as $post)
        {
            if ($post->getAuthor() !== null)
            {
                $userIds[] = $post->getAuthor();
            }
        }
        $users = $this->userRepository->listUsers($userIds);
        $usersMap = [];
        foreach ($users as $user)
        {
            $usersMap[$user->getId()] = $user;
        }

        $postsView = [];
        foreach ($posts as $post)
        {
            $user = $usersMap[$post->getAuthor()] ?? null;
            $userEmail = $user ? $user->getEmail() : null;
            $postsView[] = new PostData(
                $post->getId(),
                $post->getTitle(),
                $post->getSubtitle(),
                $post->getContent(),
                $post->getImagePath(),
                $post->getAuthor(),
                $userEmail,
                $post->getPostedAt(),
            );
        }

        return  $postsView;
    }
}