<?php

// src/Controller/PersonController.php
namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/person/create', name: 'app_person_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        // 1. Création de l'objet
        $person = new Person();
        $person->setLastname('Doe');
        $person->setFirstname('John');
        $person->setEmail('john.doe@example.com');
        $person->setBirthdate(new \DateTime('1990-01-01'));

        // 2. Dire à Doctrine de "persister" l'objet (le préparer)
        $entityManager->persist($person);

        // 3. Exécuter réellement la requête SQL
        $entityManager->flush();

        return new Response('Nouvelle personne enregistrée avec l\'id : '.$person->getId());
    }
}
