<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(EntityManagerInterface $em, ProductRepository $productRepository) {

        // $productRepository = $em->getRepository(Product::class);
        $products = $productRepository->findBy([], [], 3);

        // $product->setPrice(2500);
        // $em->flush($product);


        return $this->render('home.html.twig', [
            'products' => $products
        ]);

    }
}