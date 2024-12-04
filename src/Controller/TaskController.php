<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController
{
    // Injection automatique via le constructeur
    public function __construct(private EntityManagerInterface $em)
    {
    }

    // Route pour cr�er une t�che
    #[Route('/tasks', methods: ['POST'])]
    public function createTask(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // V�rification des champs obligatoires
        if (!isset($data['title']) || !isset($data['description']) || !isset($data['status'])) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        // Cr�ation de la t�che
        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setStatus($data['status']);
        $task->setCreatedAt(new \DateTime()); // Date de cr�ation
        $task->setUpdatedAt(new \DateTime()); // Date de mise � jour

        // Sauvegarde dans la base de donn�es
        $this->em->persist($task);
        $this->em->flush();

        // Retour de la t�che cr��e
        return new JsonResponse([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'created_at' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $task->getUpdatedAt()->format('Y-m-d H:i:s'),
        ], 201);
    }

    // Route pour mettre � jour une t�che
    #[Route('/tasks/{id}', methods: ['PUT'])]
    public function updateTask($id, Request $request): JsonResponse
    {
        // Recherche de la t�che
        $task = $this->em->getRepository(Task::class)->find($id);

        if (!$task) {
            return new JsonResponse(['error' => 'Task not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        // Mise � jour des champs uniquement si des valeurs sont fournies
        if (isset($data['title'])) {
            $task->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $task->setDescription($data['description']);
        }
        if (isset($data['status'])) {
            $task->setStatus($data['status']);
        }

        $task->setUpdatedAt(new \DateTime()); // Mise � jour de la date de modification
        $this->em->flush();

        // Retour de la t�che mise � jour
        return new JsonResponse([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'created_at' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $task->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    // Route pour supprimer une t�che
    #[Route('/tasks/{id}', methods: ['DELETE'])]
    public function deleteTask($id): JsonResponse
    {
        // Recherche de la t�che � supprimer
        $task = $this->em->getRepository(Task::class)->find($id);

        if (!$task) {
            return new JsonResponse(['error' => 'Task not found'], 404);
        }

        $this->em->remove($task);
        $this->em->flush();

        return new JsonResponse(['message' => 'Task deleted successfully']);
    }
}
