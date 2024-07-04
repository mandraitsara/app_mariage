<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Entity\Prestataire;
use Psr\Log\LoggerInterface;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/image')]
class ImageController extends AbstractController
{
    #[Route('/', name: 'app_image_index', methods: ['GET'])]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    #[Route('/image/new', name: 'app_image_new', methods: ['GET'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security, LoggerInterface $logger): Response
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur est un prestataire
        /*   if (!$user instanceof Prestataire) {
            $logger->error('Utilisateur non authentifié ou non prestataire.');
            return $this->redirectToRoute('app_image_index');
        }

        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $image->setImageFile($imageFile);
                $image->setPrestataire($user);
                $entityManager->persist($image);
                $entityManager->flush();

                $logger->info('Image uploaded and entity persisted.', ['image' => $image->getImage()]);

                return $this->redirectToRoute('app_image_index');
            } else {
                $logger->warning('No file uploaded.');
            }
        }
*/
        return $this->render('image/new.html.twig', [
            //'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_image_show', methods: ['GET'])]
    public function show(Image $image): Response
    {
        return $this->render('image/show.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $image->setImageFile($imageFile);
                $entityManager->persist($image);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('image/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_image_delete', methods: ['POST'])]
    public function delete(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_image_index', [], Response::HTTP_SEE_OTHER);
    }
}
