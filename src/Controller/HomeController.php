<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Event\ContactSuccessEvent;
use App\Form\ContactType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(EntityManagerInterface $em, ProductRepository $productRepository, Request $request, EventDispatcherInterface $dispatcher) {

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contactEvent = new ContactSuccessEvent($contact);
            $dispatcher->dispatch($contactEvent, 'contact.success');

            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('homepage');
        }
        // $productRepository = $em->getRepository(Product::class);
        $products = $productRepository->findBy([], [], 3);

        // $product->setPrice(2500);
        // $em->flush($product);


        return $this->render('home.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);

    }
}