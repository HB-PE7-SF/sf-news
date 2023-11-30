<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[Route('/api/articles')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_api_article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->json(
            $articles,
            context: [
                'groups' => ['articles:read']
            ]
        );
    }

    #[Route('/{id}', name: 'api_article_item')]
    public function item(Article $article): Response
    {
        return $this->json($article, context: [
            'groups' => ['articles:read:item']
        ]);
    }
}