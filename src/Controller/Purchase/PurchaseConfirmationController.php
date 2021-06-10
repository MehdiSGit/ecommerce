<?php

namespace App\Controller\Purchase;

use App\Cart\CartService;
use App\Form\CartConfirmationType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class PurchaseConfirmationController
{
    protected $formFactory;
    protected $router;
    protected $security;
    protected $cartService;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router, Security $security, CartService $cartService)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->security = $security;
        $this->cartService = $cartService;
    }

    /**
     * @Route("/purchase/confirm", name="purchase_confirm")
     */
    public function confirm(Request $request, FlashBagInterface $flashbag)
    {
        // 1. Nous voulons lire les données du formulaire
        // FormFactoryInterface / Request
        $form = $this->formFactory->create(CartConfirmationType::class);

        $form->handleRequest($request);

        // 2. Si le formulaire n'a pas été soumis : dégager
        if(!$form->isSubmitted())
        {   
            // Message flash puis redirection (FlashBagInterface)
            $flashbag->add('warning', 'Vous devez remplir le formulaire de confirmation');
            return new RedirectResponse($this->router->generate('cart_show'));
        }

        // 3. Si je ne suis pas connecté dégager (Security)
        $user = $this->security->getUser();

        if(!$user)
        {
            throw new AccessDeniedException("Vous devez être connecté pour effectuer une commande");
        }

        // 4.  Si il n'y a pas de produit dans mon panier : dégager (CartService)
        $cartItems = $this->cartService->getDetailedCartItems();

        if(!count($cartItems) === 0)
        {
            $flashbag->add('warning', 'Vous ne pouvez pas confirmer une commande avec un panier vide');

            return new RedirectResponse($this->router->generate('cart_show'));
        }

        // 5. nous allons créer une purchase

        //6. Nous allons la lier avec l'utilisateur actuellement connecté (Security)

        // 7. Nous allons la lier avec les produits qui sont dans le panier (CartService)

        // 8. Nous allons enregistrer la commande (EntityManagerInterface)
    }


}