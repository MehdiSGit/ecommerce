<?php

namespace App\Controller\Purchase;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PurchasesListController extends AbstractController
{   
    protected $security;
    protected $routeur;
    protected $twig;

    public function __construct(Security $security, RouterInterface $routeur, Environment $twig)
    {
        $this->security = $security;
        $this->routeur = $routeur;
        $this->twig = $twig;
    }

    /**
     * @Route("/purchases", name="pruchase_index")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour accéder à vos commandes")
     */
    public function index()
    {
        // 1. Nous devons nous assurer que la personne est connectée (sinon redirection vers la page d'accueil) -> Security
        /** @var User */
        $user = $this->security->getUser();

        // if(!$user)
        // {
        //     throw new AccessDeniedException("Vous devez être connecté pour accéder à vos commandes");
        //     // Générer une URL en fonction d'un nom d'une route ->UrlGeneratorInfterface
        // }

        // 2. Nous voulons savoir qui est connécté ->securiy
        // 3. Nous voulons passer l'utilisateur connecté à twig afin d'afficher ses commandes ->Environnement de twig / response
        $html = $this->twig->render('purchase/index.html.twig', [
            'purchases' => $user->getPurchases()
        ]);
        return new Response($html);
    }
}

