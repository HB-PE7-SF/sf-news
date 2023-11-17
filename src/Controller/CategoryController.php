<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }


    #[Route('/', name: 'categories_list')]
    public function list(): Response
    {
        return $this->render('category/list.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'category_item')]
    public function item(int $id): Response
    {
        $category = $this->categoryRepository->find($id);

        if ($category === null) {
            throw new NotFoundHttpException('Catégorie non trouvée');
        }

        return $this->render('category/item.html.twig', [
            'category' => $category
        ]);
    }
}
