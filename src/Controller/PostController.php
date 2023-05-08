<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Input\CreatePostInput;
use App\Service\Data\PostData;
use App\Service\PostService;
use App\Service\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    private PostService $postService;
    private ImageService $imageService;

    public function __construct(PostService $postService, ImageService $imageService)
    {
        $this->postService = $postService;
        $this->imageService = $imageService;
    }

    public function create(): Response
    {
        $input = new CreatePostInput();
        $form = $this->createForm(CreatePostInput::class, $input, [
            'action' => $this->generateUrl('add_post'),
        ]);

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function publishPost(Request $request): Response
    {
        $input = new CreatePostInput();
        $form = $this->createForm(CreatePostInput::class, $input);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $imageData = $form->get('image')->getData();
            $imagePath = null;
            if ($imageData !== null)
            {
                $imagePath = $this->imageService->moveImageToUploads($imageData);
            }

            $postId = $this->postService->createPost(
                $input->getTitle(),
                $input->getSubTitle(),
                $input->getContent(),
                $imagePath,
                $this->getUser()->getId()
            );

            return $this->redirectToRoute(
                'show_post',
                ['postId' => $postId],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->redirectToRoute('index');
    }

    public function viewPost(int $postId): Response
    {
        $user = $this->getUser();
        $post = $this->postService->getPost($postId);
        if ($post === null)
        {
            throw $this->createNotFoundException();
        }
        return $this->render('post/post.html.twig', [
            'canRemove' => $user->isAdmin() || $user->getId() === $post->getAuthor(),
            'post' => $this->postDataToArray($post)
        ]);
    }

    public function deletePost(int $postId): Response
    {
        $user = $this->getUser();
        $post = $this->postService->getPost($postId);
        if ($post === null)
        {
            return $this->redirectToRoute('index');
        }
        if (!$user->isAdmin() && $post->getAuthor() !== $user->getId())
        {
            throw $this->createAccessDeniedException();
        }
        $this->postService->deletePost($postId);

        return $this->redirectToRoute('index');
    }

    public function listPosts(): Response
    {
        $posts = $this->postService->listPosts();
        return $this->render('post/list.html.twig', [
            'posts_list' => $this->postsToArray($posts)
        ]);
    }

    /**
     * @param PostData[] $posts
     * @return array
     */
    private function postsToArray(array $posts): array
    {
        return array_map(function (PostData $post): array {
            return $this->postDataToArray($post);
        }, $posts);
    }

    private function postDataToArray(PostData $post): array
    {
        return [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'subtitle' => $post->getSubtitle(),
            'content' => $post->getContent(),
            'image' => $post->getImagePath(),
            'posted_at' => $post->getPostedAt()->format('Y-m-d'),
            'author_email' => $post->getAuthorEmail(),
        ];
    }
}
