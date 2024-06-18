<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\UserLogin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;

class ComptePrincipaleController extends AbstractController
{
    #[Route('comptePrincipale/', name: 'app_compte_principale')]
    public function comptePrincipale(AuthenticationUtils $authenticationUtils, UserInterface $userInterface, EntityManagerInterface $entityManager): Response
    {
        $templates = 'compte_principale.html.twig';

        if (!$userInterface) {
            return $this->redirectToRoute('app_login');
        }

        $Id_Name = $userInterface->getId();
        $activity = $entityManager->getRepository(Activity::class)
            ->activityId($Id_Name)
            ->getUser()
            ->getUsername();

        $username =  $authenticationUtils->getLastUsername();

        if ($username == null) {
            return $this->redirectToRoute('app_login');
        }

        $content = [
            'username' => $username,
            'is_activated' => $activity,
        ];
        return $this->render($templates, $content);
    }

    #[Route('activite/new/{id}', name: 'active_new.app_mariage', methods: ['PUT'])]
    public function activiteEdit(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface, int $id): Response
    {
        $project = $entityManager->getRepository(Activity::class)->find($id);

        if ($project) {
            $project->setNomH($request->request->get('name_epoux'));
            $project->setPrenomH($request->request->get('lastname_epoux'));
            $project->setNomF($request->request->get('name_epouse'));
            $project->setPrenomF($request->request->get('lastname_epouse'));

            $entityManager->flush();

            $data = [
                'id' => $project->getId(),
                'name_epoux' => $project->getTemoinF(),
                'lastname_epoux' => $project->getPrenomH(),
                'name_epouse' => $project->getNomF(),
                'lastname_epouse' => $project->getPrenomF()
            ];

            return $this->json($data);
        }

        $data = [
            'id' => $project->getId(),
            'name_epoux' => $project->getNomH(),
            'lastname_epoux' => $project->getPrenomH(),
            'name_epouse' => $project->getNomF(),
            'lastname_epouse' => $project->getPrenomF()
        ];

        return $this->json($data);
    }
}
