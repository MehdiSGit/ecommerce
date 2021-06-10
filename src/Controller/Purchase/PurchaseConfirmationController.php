<?php

namespace App\Controller\Purchase;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseConfirmationController extends AbstractController
{
    protected $cartService;
    protected $em;

    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
        $this->cartService = $cartService;
        $this->em = $em;
    }

    /**
     * @Route("/purchase/confirm", name="purchase_confirm")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour confirmer une commande")
     */
    public function confirm(Request $request)
    {
        // 1. Nous voulons lire les données du formulaire
        // FormFactoryInterface / Request
        $form = $this->createForm(CartConfirmationType::class);

        $form->handleRequest($request);

        // 2. Si le formulaire n'a pas été soumis : dégager
        if(!$form->isSubmitted())
        {   
            // Message flash puis redirection (FlashBagInterface)
            $this->addFlash('warning', 'Vous devez remplir le formulaire de confirmation');
            return $this->redirectToRoute('cart_show');
        }

        // 3. Si je ne suis pas connecté dégager (Security)
        $user = $this->getUser();

        // 4.  Si il n'y a pas de produit dans mon panier : dégager (CartService)
        $cartItems = $this->cartService->getDetailedCartItems();

        if(!count($cartItems) === 0)
        {
            $this->addFlash('warning', 'Vous ne pouvez pas confirmer une commande avec un panier vide');

            return $this->redirectToRoute('cart_show');
        }

        // 5. nous allons créer une purchase
        /** @var Purchase */
        $purchase = $form->getData();

        //6. Nous allons la lier avec l'utilisateur actuellement connecté (Security)
        $purchase->setUser($user)
                ->setPurchasedAt(new DateTime());

        $this->em->persist($purchase);


        // 7. Nous allons la lier avec les produits qui sont dans le panier (CartService)
        $total = 0;



        foreach($this->cartService->getDetailedCartItems() as $cartItem)
        {
            $purchaseItem = new PurchaseItem;
            $purchaseItem->setPurchase($purchase)
                        ->setProduct($cartItem->product)
                        ->setProductName($cartItem->product->getPrice())
                        ->setQuantity($cartItem->quantity)
                        ->setTotal($cartItem->getTotal())
                        ->setProductPrice($cartItem->product->getPrice());

            $total += $cartItem->getTotal();

            $this->em->persist($purchaseItem);
        }

        $purchase->setTotal($total);

        // 8. Nous allons enregistrer la commande (EntityManagerInterface)
        $this->em->flush();

        $this->addFlash('success', "La commande a bien été enregistrée");
        return $this->redirectToRoute('purchase_index');
    }


}