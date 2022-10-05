<?php

namespace App\Controller;

use App\Repository\AdministratorRepository;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $partners = $partnerRepository->findAll();
        $structures = $structureRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'admin' => $admin,
            'partners' => $partners,
            'structures' => $structures
        ]);
    }

    #[Route('/admin/partner-{id}', name: 'app_admin_show_partner', methods: ['GET'])]
    public function admin_show_partner(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository, int $id): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));
    
        $partner = $partnerRepository->findOneBy(array('id' => $id));
        $structures = $partner->getStructures();

        $globalPermissions = $partner->getUserId()->getUserGrants();

        return $this->render('admin/show_partner.html.twig', [
            'admin' => $admin,
            'partner' => $partner,
            'structures' => $structures,
            'globalPermissions' => $globalPermissions
        ]);
    }

    #[Route('/admin/structure-{id}', name: 'app_admin_show_structure', methods: ['GET'])]
    public function admin_show_structure(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository, int $id): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));
    
        $structure = $structureRepository->findOneBy(array('id' => $id));
        $partner = $structure->getPartnerId();

        $localPermissions = $structure->getUserId()->getUserGrants();

        return $this->render('admin/show_structure.html.twig', [
            'admin' => $admin,
            'partner' => $partner,
            'structure' => $structure,
            'localPermissions' => $localPermissions
        ]);
    }
}
