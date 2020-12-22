<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Services\UploadHelper;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route(path="/articles/{id}/edit", name="edit_article")
     *
     * @param Request $request
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @param UploadHelper $uploadHelper
     * @return Response
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

            return $this->redirectToRoute('article_list');
        }

        return $this->render('article/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @param ArticleRepository $articleRepository
     * @return Response
     * @Route(path="/articles", name="article_list")
     */
    public function articleList(
        ArticleRepository $articleRepository
    ) {
        return $this->render('article/list.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route(path="/articles/create", name="article_create")
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param UploadHelper $uploadHelper
     * @return Response
     */
    public function articleCreate(
        EntityManagerInterface $entityManager,
        Request $request,
        UploadHelper $uploadHelper
    ) {
        $article = new Article();
        $article->setCreatedAt(new DateTime());

        $form = $this->createForm(ArticleType::class, $article, [
            'method' => Request::METHOD_POST
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $article->getImageFile();

            if ($uploadedFile) {
                $article->setImage($uploadHelper->uploadImage($uploadedFile));
            }

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('article/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);

    }

    /**
     * @Route(path="/articles/{id}/delete", name="article_delete")
     *
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function articleDelete(
        Article $article,
        EntityManagerInterface $entityManager
    ) {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('article_list');
    }
}