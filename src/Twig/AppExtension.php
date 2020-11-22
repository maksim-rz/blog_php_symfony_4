<?php


namespace App\Twig;


use App\Entity\Article;
use App\Services\UploadHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var UploadHelper
     */
    private $uploadHelper;

    /**
     * AppExtension constructor.
     * @param UploadHelper $uploadHelper
     */
    public function __construct(UploadHelper $uploadHelper)
    {
        $this->uploadHelper = $uploadHelper;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('uploaded_article_asset', [$this, 'getUploadedArticleAsset']),
        ];
    }

    /**
     * @param Article $article
     * @return string|null
     */
    public function getUploadedArticleAsset(Article $article)
    {
        return $this->uploadHelper->getImagePublicPath($article);
    }
}