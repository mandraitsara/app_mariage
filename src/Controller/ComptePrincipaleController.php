<?php

namespace App\Controller;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;

class ComptePrincipaleController extends AbstractController
{
    #[Route('activite/', name: "activite.app_mariage")]
    public function activite(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface): Response
    {
        $templates = 'activity.html.twig';
        $userID = $userInterface->getId();
        $activityRepository = $entityManager->getRepository(Activity::class);
        $activity = $activityRepository->activityId($userID);

        if (!$activity) {
            throw $this->createNotFoundException('Activity not found for user ID ' . $userID);
        }

        $content = [
            'idUser' => $activity->getId(),
            'nomFemme' => $activity->getNomF(),
            'prenomFemme' => $activity->getPrenomF(),
            'nomHomme' => $activity->getNomH(),
            'prenomHomme' => $activity->getPrenomH(),
            'amis_homme' => mb_split(";", $activity->getAmiProcheH()),
            'amis_femme' => mb_split(";", $activity->getAmieProcheF()),
            'garcon_dhonneur' => mb_split(";", $activity->getGarconDHonneur()),
            'fille_dhonneur' => mb_split(";", $activity->getFilleDHonneur()),
            'parent_homme' => mb_split(";", $activity->getParentH()),
            'parent_femme' => mb_split(";", $activity->getParentF()),
            'ami_homme' => mb_split(";", $activity->getAmiH()),
            'ami_femme' => mb_split(";", $activity->getAmieF()),
        ];

        return $this->render($templates, $content);
    }

    #[Route('activite/new/{id}', name: 'active_new.app_mariage', methods: ['PUT'])]
    public function activiteEdit(Request $request, EntityManagerInterface $entityManager, UserInterface $userInterface, int $id): Response
    {
        $activity = $entityManager->getRepository(Activity::class)->find($id);

        if (!$activity) {
            return $this->json("Activity not found.", Response::HTTP_NOT_FOUND);
        }

        $activity->setGarconDHonneur($request->request->get('garcon_dhonneur'));
        $activity->setNomH($request->request->get('name_epoux'));
        $activity->setParentH($request->request->get('parents_epoux'));
        $activity->setAmiProcheH($request->request->get('famille_homme'));
        $activity->setAmiH($request->request->get('ami_epoux'));
        $activity->setNomF($request->request->get('name_epouse'));
        $activity->setFilleDHonneur($request->request->get('fille_dhonneur_epouse'));
        $activity->setParentF($request->request->get('parents_epouse'));
        $activity->setAmieF($request->request->get('ami_epouse'));
        $activity->setAmieProcheF($request->request->get('famille_femme'));

        $entityManager->flush();

        return $this->json("La modification a été effectuée...");
    }
}
