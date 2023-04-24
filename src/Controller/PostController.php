<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\View\PhpTemplateEngine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
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
            new \DateTimeImmutable(),
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
        $post = $this->postRepository->findById($postId);
        if ($post === null)
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
        $post = $this->postRepository->findById($postId);
        if ($post === null)
        {
            throw $this->createNotFoundException();
        }

        $this->postRepository->delete($post);

        return $this->redirectToRoute('list_posts');
    }

    public function listPosts(): Response
    {
        $posts = $this->postRepository->listAll();

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
