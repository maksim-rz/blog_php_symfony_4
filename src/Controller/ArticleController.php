<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @param Request $request
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route(path="/edit-route/{id}", name="edit_route")
     */
    public function editArticle(Request $request, Article $article, EntityManagerInterface $entityManager)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');

        if ($uploadedFile) {
            $destination = sprintf('%s/public/uploads/articles', $this->getParameter('kernel.project_dir'));
            $fileName = sprintf('%s-%s', uniqid(), $uploadedFile->getClientOriginalName());
            $uploadedFile->move($destination, $fileName);
            $article->setImage($fileName);
            $entityManager->flush();
        }

        return $this->render('article/edit.html.twig', []);
    }
}