<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] Person $person, 
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $entityManager->persist($person);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Personne créée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/person/{id}', name: 'app_person_get', methods: ['GET'])]
    public function getPerson(Person $person): JsonResponse
    {
        return new JsonResponse([
            'id' => $person->getId(),
            'firstname' => $person->getFirstname(),
            'lastname' => $person->getLastname(),
            'email' => $person->getEmail(),
            'birthdate' => $person->getBirthdate()->format('Y-m-d'),
        ]);
    }

    // --- ÉTAPE 2.6 : SUPPRIMER UNE PERSONNE ---
    #[Route('/person/{id}', name: 'app_person_delete', methods: ['DELETE'])]
    public function delete(Person $person, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($person);
        $entityManager->flush();
        return new JsonResponse(['message' => 'Personne supprimée avec succès'], Response::HTTP_OK);
    }
}