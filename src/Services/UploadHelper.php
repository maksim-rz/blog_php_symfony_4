<?php


namespace App\Services;


use App\Entity\Article;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    public const ARTICLE_IMAGE_FOLDER = 'articles';
    /**
     * @var string
     */
    private $uploadPath;

    /**
     * UploadHelper constructor.
     * @param string $uploadPath
     */
    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function uploadImage(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = sprintf('%s-%s.%s', $originalFilename, uniqid(), $file->guessExtension())  ;
        $file->move($this->uploadImagePath(), $fileName);

        return $fileName;
    }

    /**
     * @param Article $article
     * @return string|null
     */
    public function getImagePublicPath(Article $article): ?string
    {
        if (!$article->getImage()) {
            return null;
        }

        return sprintf('%s/%s', $this->uploadPublicPath(), $article->getImage());
    }

    /**
     * @return string
     */
    private function uploadPublicPath(): string
    {
        return sprintf('uploads/%s', self::ARTICLE_IMAGE_FOLDER);
    }

    /**
     * @return string
     */
    private function uploadImagePath(): string
    {
        return sprintf('%s/%s', $this->uploadPath, self::ARTICLE_IMAGE_FOLDER);
    }
}