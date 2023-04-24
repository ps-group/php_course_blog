<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PostRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Post::class);
    }

    public function findById(int $id): ?Post
    {
        return $this->repository->findOneBy(['id' => (string) $id]);
    }

    public function store(Post $post): int
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }

    public function delete(Post $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    /**
     * @return Post[]
     */
    public function listAll(): array
    {
        return $this->repository->findAll();
    }
}
