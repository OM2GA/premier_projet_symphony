<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse 
    {
        $data = json_decode($request->getContent(), true);

        $person = new Person();
        $person->setFirstname($data['firstname']);
        $person->setLastname($data['lastname']);
        $person->setEmail($data['email']);
        $person->setBirthdate(new \DateTime($data['birthdate']));

        $address = new Address();
        $address->setStreet($data['address']['street']);
        $address->setCity($data['address']['city']);
        $address->setZipCode($data['address']['zipCode']);

        $person->setAddress($address);

        $entityManager->persist($person);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Personne et adresse créées avec succès'], Response::HTTP_CREATED);
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
            'address' => [
                'street' => $person->getAddress()->getStreet(),
                'city' => $person->getAddress()->getCity(),
                'zipCode' => $person->getAddress()->getZipCode(),
            ]
        ]);
    }
}