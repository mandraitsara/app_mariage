<?php

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        // Nouveau nom de l'image
        $fileName = md5(uniqid(rand(), true)) . '.webp';

        // Récupération des infos de l'image
        $picturePath = $picture->getPathname();
        $pictureInfos = getimagesize($picturePath);

        if ($pictureInfos === false) {
            throw new \Exception('Format incorrect');
        }

        // Vérification du format de l'image
        switch ($pictureInfos['mime']) {
            case 'image/png':
                $pictureSource = imagecreatefrompng($picturePath);
                break;
            case 'image/jpeg':
                $pictureSource = imagecreatefromjpeg($picturePath);
                break;
            case 'image/webp':
                $pictureSource = imagecreatefromwebp($picturePath);
                break;
            default:
                throw new \Exception('Format incorrect');
        }

        // Création d'une image vide avec les nouvelles dimensions
        $resizedPicture = imagecreatetruecolor($width, $height);

        // Copie et redimensionnement de l'image
        imagecopyresampled($resizedPicture, $pictureSource, 0, 0, 0, 0, $width, $height, $pictureInfos[0], $pictureInfos[1]);

        // Définition du répertoire de destination
        $folder = rtrim($folder, '/') . '/';
        $destination = $this->params->get('images_directory') . '/' . $folder;

        // Création du répertoire s'il n'existe pas
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Enregistrement de l'image en format WebP
        imagewebp($resizedPicture, $destination . $fileName);

        // Libération de la mémoire
        imagedestroy($pictureSource);
        imagedestroy($resizedPicture);

        return $fileName;
    }
}
