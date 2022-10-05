<?php

namespace App\Controller;

use App\Repository\StructureRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StructureController extends AbstractController
{
    #[Route('/structure', name: 'app_structure')]
    public function index(StructureRepository $structureRepository, PartnerRepository $partnerRepository): Response
    {
        $currentUser = $this->getUser();
        $structure = $structureRepository->findOneBy(array('userId' => $currentUser->getId()));
        $partner = $partnerRepository->findOneBy(array('id' => $structure->getPartnerId()));

        $localPermissions = $currentUser->getUserGrants();

        return $this->render('structure/index.html.twig', [
            'structure' => $structure,
            'partner' => $partner,
            'localPermissions' => $localPermissions
        ]);
    }
}
