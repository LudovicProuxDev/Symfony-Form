<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private const MIMETYPE_IMAGES = 'image/';
    private const MIMETYPE_PDF = 'application/pdf';

    public function __construct(
        private string $uploadsDirectory,
        private string $imagesDirectory,
        private string $pdfDirectory,
        private SluggerInterface $slugger,
    ) {}

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $this->defineFileName($safeFilename, $file->guessExtension());
        $targetDirectory = $this->getTargetDirectoryByMimeType($file->getClientMimeType());

        try {
            $file->move($targetDirectory, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            throw new FileException($e->getMessage());
        }

        return $fileName;
    }

    public function getUploadsDirectory(): string
    {
        return $this->uploadsDirectory;
    }

    public function getImagesDirectory(): string
    {
        return $this->imagesDirectory;
    }

    public function getPdfDirectory(): string
    {
        return $this->pdfDirectory;
    }

    private function defineFileName(string $fileName, string $extension): string
    {
        // Return file name : Filename . Datetime . Uuid . Extension
        return $fileName . '-' . (new \DateTime('now', new \DateTimeZone('Europe/Paris')))->format('YmdHis') . '-' . uniqid() . '.' . $extension;
    }

    private function getTargetDirectoryByMimeType(string $mimeType): string
    {
        // Image
        if (str_contains($mimeType, self::MIMETYPE_IMAGES)) {
            return $this->getImagesDirectory();
        }
        // PDF
        if ($mimeType === self::MIMETYPE_PDF) {
            return $this->getPdfDirectory();
        }
        // Default
        return $this->getUploadsDirectory();
    }
}
