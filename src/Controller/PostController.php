<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\Doctrine\EntityManagerProvider;
use App\Infrastructure\MySQL\ConnectionProvider;
use App\Infrastructure\MySQL\PostTable;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\View\PhpTemplateEngine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    // TODO удалить, полностью заменив на PostRepository
    private PostTable $postTable;

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postTable = new PostTable(ConnectionProvider::getConnection());
        $this->postRepository = $postRepository;
    }

    public function index(): Response
    {
        $contents = PhpTemplateEngine::render('add_post_form.php');
        return new Response($contents);
    }

    public function publishPost(Request $request): Response
    {
        $post = new Post(
            null,
            $request->get('title'),
            $request->get('subtitle'),
            $request->get('content'),
        );
        $postId = $this->postRepository->store($post);

        return $this->redirectToRoute(
            'show_post',
            ['postId' => $postId],
            Response::HTTP_SEE_OTHER
        );
    }

    public function viewPost(int $postId): Response
    {
        $post = $this->postTable->find($postId);
        if (!$post)
        {
            throw $this->createNotFoundException();
        }

        $contents = PhpTemplateEngine::render('post.php', [
            'post' => $post
        ]);
        return new Response($contents);
    }

    public function deletePost(int $postId): Response
    {
        $this->postTable->delete($postId);

        return $this->redirectToRoute('index');
    }

    public function listPosts(): Response
    {
        $posts = $this->postTable->list();

        $postsView = [];

        foreach ($posts as $post)
        {
            $postsView[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'subtitle' => $post->getSubtitle(),
                'content' => $post->getContent(),
                'posted_at' => $post->getPostedAt()->format('Y-m-d'),
            ];
        }

        return $this->render('post/list.html.twig', [
            'posts_list' => $postsView
        ]);
    }
}
