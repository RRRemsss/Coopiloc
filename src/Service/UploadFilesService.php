<?php

namespace App\Service;

use App\Entity\GuarantorDocument;
use App\Entity\PropertyImage;
use App\Entity\PropertyDocument;
use App\Entity\TenantDocument;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFilesService
{
    private $slugger;
    private $imagesDirectoryProperty;
    private $documentsDirectoryProperty;
    private $documentsDirectoryTenant;
    private $documentsDirectoryGuarantor;

    public function __construct(SluggerInterface $slugger, string $imagesDirectoryProperty, string $documentsDirectoryProperty, string $documentsDirectoryTenant, string $documentsDirectoryGuarantor)
    {
        $this->slugger = $slugger;
        $this->imagesDirectoryProperty = $imagesDirectoryProperty;
        $this->documentsDirectoryProperty = $documentsDirectoryProperty;
        $this->documentsDirectoryTenant = $documentsDirectoryTenant;
        $this->documentsDirectoryGuarantor = $documentsDirectoryGuarantor;
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

    public function uploadTenantDocument(UploadedFile $documentTenant): ?TenantDocument
    {
        $mimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        if (!in_array($documentTenant->getMimeType(), $mimeTypes)) {
            throw new \Exception('Type de fichier de document non valide.');
        }

        if ($documentTenant->getSize() > 10 * 1024 * 1024) { // 10MB
            throw new \Exception('Le document est trop volumineux.');
        }

        $originalFilename = pathinfo($documentTenant->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $this->slugger->slug($originalFilename) . '-' . uniqid() . '.' . $documentTenant->guessExtension();

        try {
            $documentTenant->move($this->documentsDirectoryTenant, $newFilename);
        } catch (FileException $e) {
            throw new \Exception('Erreur lors de l\'upload du document : ' . $e->getMessage());
        }

        $tenantDocument = new TenantDocument();
        $tenantDocument->setFilePathTenantDocument($newFilename);
        $tenantDocument->setCreatedAt(new \DateTime());
        $tenantDocument->setUpdatedAt(new \DateTime());

        return $tenantDocument;
    }

    public function uploadGuarantorDocument(UploadedFile $documentGuarantor): ?GuarantorDocument
    {
        $mimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        if (!in_array($documentGuarantor->getMimeType(), $mimeTypes)) {
            throw new \Exception('Type de fichier de document non valide.');
        }

        if ($documentGuarantor->getSize() > 10 * 1024 * 1024) { // 10MB
            throw new \Exception('Le document est trop volumineux.');
        }

        $originalFilename = pathinfo($documentGuarantor->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $this->slugger->slug($originalFilename) . '-' . uniqid() . '.' . $documentGuarantor->guessExtension();

        try {
            $documentGuarantor->move($this->documentsDirectoryGuarantor, $newFilename);
        } catch (FileException $e) {
            throw new \Exception('Erreur lors de l\'upload du document : ' . $e->getMessage());
        }

        $guarantorDocument = new GuarantorDocument();
        $guarantorDocument->setFilePathGuarantorDocument($newFilename);
        $guarantorDocument->setCreatedAt(new \DateTime());
        $guarantorDocument->setUpdatedAt(new \DateTime());

        return $guarantorDocument;
    }
}
