<?php

namespace App\Controller;

use App\Form\ImageUploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;

class ImageUploadController extends AbstractController
{
    #[Route('/upload', name: 'app_image_upload')]
    public function upload(Request $request): Response
    {
        $form = $this->createForm(ImageUploadType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('image')->getData();

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);                
                $newFilename = uniqid() . '.' . $file->guessExtension();

                // Déplace le fichier dans le répertoire de destination
                $file->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                // Enregistrez le nom du fichier dans votre base de données si nécessaire
              


                // ...

                $this->addFlash('success', 'Image téléchargée avec succès !');

                return $this->redirectToRoute('app_image_upload');
            }
        }

        return $this->render('upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}



?>