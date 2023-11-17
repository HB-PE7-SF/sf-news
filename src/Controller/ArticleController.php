<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'articles_list')]
    public function index(ArticleRepository $articleRepository): Response
    {
        // Récupérer les articles
        $articles = $articleRepository->findAll();

        // Les transmettre à la vue
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/articles/{id}', name: 'article_item')]
    public function item(Article $article): Response
    {
        return $this->render('article/item.html.twig', [
            'article' => $article
        ]);
    }
}
