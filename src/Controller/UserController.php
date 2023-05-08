<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Input\RegisterUserInput;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }

    public function register(Request $request): Response
    {
        $input = new RegisterUserInput();
        $form = $this->createForm(RegisterUserInput::class, $input, [
            'action' => $this->generateUrl('signup'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $input = $form->getData();
            $this->service->register($input);

            return $this->redirectToRoute('login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
