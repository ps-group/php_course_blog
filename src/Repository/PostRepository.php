<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findById(int $id): ?Post
    {
        // TODO реализовать
        throw new \RuntimeException('Not implemented');
    }

    public function store(Post $post): int
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }

    public function deleteById(int $postId): void
    {
        // TODO реализовать
        throw new \RuntimeException('Not implemented');
    }

    /**
     * @return Post[]
     */
    public function list(): array
    {
        // TODO реализовать
        throw new \RuntimeException('Not implemented');
    }
}