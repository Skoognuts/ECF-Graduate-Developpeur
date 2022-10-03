<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccessDeniedController extends AbstractController
{
    #[Route('/access-denied', name: 'app_access_denied')]
    public function index(Request $request): Response
    {
        $currentUser = $this->getUser();

        if (in_array('ROLE_ADMIN', $currentUser->getRoles(), true)) {
            $route = '\\admin';
        } else if (in_array('ROLE_PARTNER', $currentUser->getRoles(), true)) {
            $route = '\\partner';
        } else if (in_array('ROLE_STRUCTURE', $currentUser->getRoles(), true)) {
            $route = '\\structure';
        }

        return $this->render('security/access_denied.html.twig', [
            'route' => $route
        ]);
    }
}