<?php

// src/Controller/PersonController.php
namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/person/create', name: 'app_person_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $person = new Person();
        $person->setLastname($data['lastname']);
        $person->setFirstname($data['firstname']);
        $person->setEmail($data['email']);
        $person->setBirthdate(new \DateTime($data['birthdate']));

        $entityManager->persist($person);
        $entityManager->flush();

        return new Response('Succès ! Personne créée.', 201);
    }
}
