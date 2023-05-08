<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    const UPLOADS_PATH = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads';
    const ALLOWED_MIME_TYPES_MAP = [
        'image/jpeg' => '.jpg',
        'image/png' => '.png',
        'image/webp' => '.webp',
    ];

    public function moveImageToUploads(UploadedFile $file): ?string
    {
        if ($file->getError() === UPLOAD_ERR_NO_FILE)
        {
            return null;
        }

        $type = $file->getMimeType();
        $name = $file->getClientOriginalName();
        $imageExt = self::ALLOWED_MIME_TYPES_MAP[$type] ?? null;
        if (!$imageExt)
        {
            throw new \InvalidArgumentException("File '$name' has non-image type '$type'");
        }

        $destFileName = uniqid('image', true) . $imageExt;
        return $this->moveFileToUploads($file, $destFileName);
    }

    public function getUploadUrlPath(string $fileName): string
    {
        return "/uploads/$fileName";
    }

    private function getUploadPath(string $fileName): string
    {
        $uploadsPath = dirname(__DIR__, 2) . self::UPLOADS_PATH;

        if (!$uploadsPath || !is_dir($uploadsPath))
        {
            throw new \RuntimeException('Invalid uploads path: ' . self::UPLOADS_PATH);
        }

        return $uploadsPath . DIRECTORY_SEPARATOR . $fileName;
    }

    private function moveFileToUploads(UploadedFile $file, string $destFileName): string
    {
        $fileName = $file->getClientOriginalName();
        $destPath = $this->getUploadPath($destFileName);
        $srcPath = $file->getRealPath();

        if (!@move_uploaded_file($srcPath, $destPath))
        {
            throw new \RuntimeException("Failed to upload file $fileName");
        }

        return $destFileName;
    }
}