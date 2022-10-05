<?php

namespace App\Controller;

use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route('/partner', name: 'app_partner')]
    public function index(PartnerRepository $partnerRepository): Response
    {
        $currentUser = $this->getUser();
        $partner = $partnerRepository->findOneBy(array('userId' => $currentUser->getId()));

        $structures = $partner->getStructures();

        $globalPermissions = $currentUser->getUserGrants();

        return $this->render('partner/index.html.twig', [
            'partner' => $partner,
            'structures' => $structures,
            'globalPermissions' => $globalPermissions
        ]);
    }

    #[Route('/partner/structure-{id}', name: 'app_partner_show_structure', methods: ['GET'])]
    public function partner_show_structure(PartnerRepository $partnerRepository, StructureRepository $structureRepository, int $id): Response
    {
        $currentUser = $this->getUser();
        $partner = $partnerRepository->findOneBy(array('userId' => $currentUser->getId()));
    
        $structure = $structureRepository->findOneBy(array('id' => $id));
        $localPermissions = $structure->getUserId()->getUserGrants();

        return $this->render('partner/show_structure.html.twig', [
            'partner' => $partner,
            'structure' => $structure,
            'localPermissions' => $localPermissions
        ]);
    }
}
