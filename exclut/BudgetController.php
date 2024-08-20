<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BudgetController extends AbstractController
{

    #[Route('/budget', name: 'budget_index')]

    public function index(BudgetRepository $budgetRepository)
    {
        $budget = $budgetRepository->findOneBy(['user_login' => $this->getUser()]);
        // Vérifie si le budget existe
        if (!$budget) {
            // Redirection vers la création du budget ou autre action
            return $this->redirectToRoute('budget_create');
        }

        return $this->render('budget/index.html.twig', [
            'budget' => $budget,
        ]);
    }

    #[Route('/budget/create', name: 'budget_create')]

    public function create(Request $request, EntityManagerInterface $em)
    {
        $budget = new Budget();
        $form = $this->createForm(BudgetType::class, $budget);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $budget->setUserLogin($this->getUser());
            $em->persist($budget);
            $em->flush();

            return $this->redirectToRoute('budget_index');
        }

        return $this->render('budget/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/budget/edit/{id}', name: 'budget_edit')]

    public function edit(Budget $budget, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(BudgetType::class, $budget);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('budget_index');
        }

        return $this->render('budget/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
