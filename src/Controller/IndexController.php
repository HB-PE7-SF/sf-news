<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'title' => 'News',
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig');
    }

    #[Route('/newsletter/subscribe', name: 'app_newsletter_subscribe')]
    public function newsletterSubscribe(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $newsletterEmail = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletterEmail);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsletterEmail
                ->setSubscribed(true)
                ->setSubscriptionDate(new \DateTime());

            $em->persist($newsletterEmail);
            $em->flush();

            $this->addFlash('success', 'Merci, votre email a bien été enregistré à la newsletter');
            return $this->redirectToRoute('homepage');
        }

        return $this->renderForm('index/newsletter_subscribe.html.twig', [
            'newsletter_form' => $form
        ]);
    }
}
