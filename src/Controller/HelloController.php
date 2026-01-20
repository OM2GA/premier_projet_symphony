<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function hello(): Response
    {
        $lastname = 'Doe';
        $firstname = 'John';

        return $this->render('hello.html.twig', [
            'lastname' => $lastname,
            'firstname' => $firstname
        ]);
    }
}