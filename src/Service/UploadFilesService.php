<?php

namespace App\Service;

use App\Entity\PropertyImage;
use App\Entity\PropertyDocument;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFilesService
{
    private $slugger;
    private $imagesDirectoryProperty;
    private $documentsDirectoryProperty;

    public function __construct(SluggerInterface $slugger, string $imagesDirectoryProperty, string $documentsDirectoryProperty)
    {
        $this->slugger = $slugger;
        $this->imagesDirectoryProperty = $imagesDirectoryProperty;
        $this->documentsDirectoryProperty = $documentsDirectoryProperty;
    }

    public function uploadImageProperty(UploadedFile $image): ?PropertyImage
    {
        $mimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image->getMimeType(), $mimeTypes)) {
            throw new \Exception('Type de fichier d\'image non valide.');
        }

        if ($image->getSize() > 5 * 1024 * 1024) { // 5MB
            throw new \Exception('L\'image est trop volumineuse.');
        }

        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $this->slugger->slug($originalFilename) . '-' . uniqid() . '.' . $image->guessExtension();

        try {
            $image->move($this->imagesDirectoryProperty, $newFilename);
        } catch (FileException $e) {
            throw new \Exception('Erreur lors de l\'upload de l\'image : ' . $e->getMessage()); 
        }

        $propertyImage = new PropertyImage();
        $propertyImage->setFilePathPropertyImage($newFilename);
        $propertyImage->setCreatedAt(new \DateTime());
        $propertyImage->setUpdatedAt(new \DateTime());

        return $propertyImage;
    }

    public function uploadDocumentProperty(UploadedFile $document): ?PropertyDocument
    {
        $mimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        if (!in_array($document->getMimeType(), $mimeTypes)) {
            throw new \Exception('Type de fichier de document non valide.');
        }

        if ($document->getSize() > 10 * 1024 * 1024) { // 10MB
            throw new \Exception('Le document est trop volumineux.');
        }

        $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $this->slugger->slug($originalFilename) . '-' . uniqid() . '.' . $document->guessExtension();

        try {
            $document->move($this->documentsDirectoryProperty, $newFilename);
        } catch (FileException $e) {
            throw new \Exception('Erreur lors de l\'upload du document : ' . $e->getMessage());
        }

        $propertyDocument = new PropertyDocument();
        $propertyDocument->setFilePathPropertyDocument($newFilename);
        $propertyDocument->setCreatedAt(new \DateTime());
        $propertyDocument->setUpdatedAt(new \DateTime());

        return $propertyDocument;
    }
}
