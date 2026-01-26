<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/person/create', name: 'app_person_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new Response('Erreur : JSON invalide', 400);
        }

        $person = new Person();
        $person->setLastname($data['lastname'] ?? 'Inconnu');
        $person->setFirstname($data['firstname'] ?? 'Inconnu');
        $person->setEmail($data['email'] ?? 'test@test.fr');
        
        $birthdate = new \DateTime($data['birthdate'] ?? 'now');
        $person->setBirthdate($birthdate);

        $entityManager->persist($person);
        $entityManager->flush();

        return new Response('Personne ajoutée avec succès ! ID : ' . $person->getId());
    }
}