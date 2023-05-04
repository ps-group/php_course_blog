<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Service\PostServiceInterface;
use App\Service\ImageServiceInterface;
use App\View\PhpTemplateEngine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    private PostServiceInterface $postService;
    private ImageServiceInterface $imageService;

    public function __construct(PostServiceInterface $postService, ImageServiceInterface $imageService)
    {
        $this->postService = $postService;
        $this->imageService = $imageService;
    }

    public function index(): Response
    {
        $contents = PhpTemplateEngine::render('add_post_form.php');
        return new Response($contents);
    }

    public function publishPost(Request $request): Response
    {
        $imagePath = (isset($_FILES['image'])) ? $this->imageService->moveImageToUploads($_FILES['image']) : null;        
        
        $postId = $this->postService->savePost(
            $request->get('title'),
            $request->get('subtitle'),
            $request->get('content'),
            $imagePath,
        );

        return $this->redirectToRoute(
            'show_post',
            ['postId' => $postId],
            Response::HTTP_SEE_OTHER
        );
    }

    public function viewPost(int $postId): Response
    {
        $post = $this->postService->getPost($postId);

        $contents = PhpTemplateEngine::render('post.php', [
            'post' => $post
        ]);
        return new Response($contents);
    }

    public function deletePost(int $postId): Response
    {
        $this->postService->deletePost($postId);

        return $this->redirectToRoute('list_posts');
    }

    public function listPosts(): Response
    {
        $posts = $this->postService->listPosts();
        $postsView = [];
        foreach ($posts as $post)
        {
            $postsView[] = $post->toArray();
        }

        return $this->render('post/list.html.twig', [
            'posts_list' => $postsView
        ]);
    }
}
