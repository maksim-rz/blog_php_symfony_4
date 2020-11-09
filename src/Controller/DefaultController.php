<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @param $aaa
     * @return Response
     * @Route(path="", name="home")
     */
    public function index()
    {
        return $this->render('lucky/index.html.twig', []);
    }

    /**
     * @param ArticleRepository $articleRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request)
    {
        $queryBuilder = $articleRepository->findArticlesQueryBuilder();

        $articles = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9   /*limit per page*/
        );

        return $this->render('lucky/blog.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @param Article $article
     * @return Response
     *
     * @Route("/blog/{id}", name="single_blog")
     */
    public function singleBlog(Article $article)
    {

        return $this->render('lucky/single_blog.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/team", name="team")
     */
    public function team()
    {
        return $this->render('lucky/team.html.twig', []);
    }

    /**
     * @return Response
     *
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('lucky/contact.html.twig', []);
    }

    /**
     * @Route(path="/add-article", name="add-article")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function next(EntityManagerInterface $entityManager, Request $request)
    {
//        $category = new Category();
//        $category->setTitle('aaaaaaa');

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article, ['method' => $request->getMethod()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Done!');
            return $this->redirect('add-article');
        }

        return $this->render('lucky/article_form.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/articles/{id}", name="edit-article")
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function editArticle(Article $article, EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(
            ArticleType::class,
            $article,
            ['method' => $request->getMethod()]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Done!');
            return $this->redirectToRoute('edit-article', ['id' => $article->getId() ]);
        }

        return $this->render('lucky/article_form.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/articles/delete/{id}")
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function deleteArticle(Article $article, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return new Response('Deleted');
    }

    /**
     * @Route(path="/abv")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function list2(EntityManagerInterface $entityManager)
    {
        $articleRepository= $entityManager->getRepository(Article::class);
        $articles = $articleRepository->findAll();

        dd($articleRepository->findByCategoryId(2));


        return new Response('List');
    }
}