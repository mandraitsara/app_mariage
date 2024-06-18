<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Prestataire;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/image')]
class ImageController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    #[Route('/', name: 'app_image_index', methods: ['GET'])]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_image_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security, LoggerInterface $logger): Response
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur est un prestataire
        if (!$user instanceof Prestataire) {
            $logger->error('Utilisateur non authentifié ou non prestataire.');
            return $this->redirectToRoute('app_image_index');
        }

        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('image')->getData();

            if ($uploadedFiles) {
                foreach ($uploadedFiles as $uploadedFile) {
                    if ($uploadedFile) {
                        $fileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();

                        try {
                            $uploadedFile->move(
                                $this->params->get('images_directory'),
                                $fileName
                            );

                            // Créer une nouvelle instance d'Image
                            $img = new Image();
                            $img->setName($form->get('name')->getData());
                            $img->setImage($fileName);
                            $img->setPrestataire($user);

                            // Persister l'objet Image
                            $entityManager->persist($img);
                            $logger->info('Image uploaded and entity persisted.', ['image' => $fileName]);
                        } catch (\Exception $e) {
                            $logger->error('File upload error: ' . $e->getMessage());
                        }
                    }
                }

                // Exécuter les opérations SQL
                $entityManager->flush();

                // Rediriger vers la liste des images
                return $this->redirectToRoute('app_image_index');
            } else {
                $logger->warning('No files uploaded.');
            }
        }

        return $this->render('image/new.html.twig', [
            'form' => $form->createView(),
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
            $uploadedFiles = $form->get('image')->getData();

            if ($uploadedFiles) {
                foreach ($uploadedFiles as $uploadedFile) {
                    $fileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                    $uploadedFile->move(
                        $this->params->get('images_directory'),
                        $fileName
                    );

                    $img = new Image();
                    $img->setImage($fileName);
                    $img->setPrestataire($image->getPrestataire());
                    $entityManager->persist($img);
                }
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
