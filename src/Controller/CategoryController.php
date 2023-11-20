<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/{id<\d+>}', name: 'category_item')]
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

    #[Route('/new', name: 'category_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Je crée une instance de l'entité
        // et je la lie au formulaire
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        // Avec la requête entrante, je vais vouloir traiter les données du formulaire
        $form->handleRequest($request);

        // Une fois la requête entrante traitée (si des données s'y trouvent)
        // Je vais vérifier si le formulaire a bien été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // persister l'entité $category
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories_list');
        }

        return $this->renderForm(
            'category/new.html.twig',
            ['category_form' => $form]
        );
    }
}
