<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
}
