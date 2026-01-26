<?php

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
        // 1. Récupérer les données envoyées en JSON
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new Response('Erreur : JSON invalide', 400);
        }

        // 2. Créer l'objet Person avec les données reçues
        $person = new Person();
        $person->setLastname($data['lastname'] ?? 'Inconnu');
        $person->setFirstname($data['firstname'] ?? 'Inconnu');
        $person->setEmail($data['email'] ?? 'test@test.fr');
        
        // Conversion de la date (format Y-m-d)
        $birthdate = new \DateTime($data['birthdate'] ?? 'now');
        $person->setBirthdate($birthdate);

        // 3. Sauvegarder en base de données
        $entityManager->persist($person);
        $entityManager->flush();

        // 4. RÉPONSE OBLIGATOIRE (pour éviter votre erreur actuelle)
        return new Response('Personne ajoutée avec succès ! ID : ' . $person->getId());
    }
}