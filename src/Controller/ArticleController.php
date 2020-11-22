<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Services\UploadHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @param Request $request
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @param UploadHelper $uploadHelper
     * @return Response
     * @Route(path="/edit-route/{id}", name="edit_route")
     */
    public function editArticle(
        Request $request,
        Article $article,
        EntityManagerInterface $entityManager,
        UploadHelper $uploadHelper
    ) {

        $form = $this->createForm(ArticleType::class, $article, [
            'method' => Request::METHOD_POST
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $article->getImageFile();

            if ($uploadedFile) {
                $article->setImage($uploadHelper->uploadImage($uploadedFile));
            }

            $entityManager->flush();
        }

        return $this->render('article/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }
}