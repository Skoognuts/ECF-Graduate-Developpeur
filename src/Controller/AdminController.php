<?php

namespace App\Controller;

use App\Repository\AdministratorRepository;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        $activPartnerLinks = [true, false, false];
        $activStructureLinks = [true, false, false];

        return $this->render('admin/index.html.twig', [
            'admin' => $admin,
            'partners' => $partners,
            'structures' => $structures,
            'activPartnerLinks' => $activPartnerLinks,
            'activStructureLinks' => $activStructureLinks
        ]);
    }

    #[Route('/admin/activ-partners', name: 'app_admin_activ_partners')]
    public function index_activ_partners(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $partners = $partnerRepository->findBy(array('isActive' => true));
        $structures = $structureRepository->findAll();

        $activPartnerLinks = [false, true, false];
        $activStructureLinks = [true, false, false];

        return $this->render('admin/index.html.twig', [
            'admin' => $admin,
            'partners' => $partners,
            'structures' => $structures,
            'activPartnerLinks' => $activPartnerLinks,
            'activStructureLinks' => $activStructureLinks
        ]);
    }

    #[Route('/admin/innactiv-partners', name: 'app_admin_innactiv_partners')]
    public function index_innactiv_partners(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $partners = $partnerRepository->findBy(array('isActive' => false));
        $structures = $structureRepository->findAll();

        $activPartnerLinks = [false, false, true];
        $activStructureLinks = [true, false, false];

        return $this->render('admin/index.html.twig', [
            'admin' => $admin,
            'partners' => $partners,
            'structures' => $structures,
            'activPartnerLinks' => $activPartnerLinks,
            'activStructureLinks' => $activStructureLinks
        ]);
    }

    #[Route('/admin/activ-structures', name: 'app_admin_activ_structures')]
    public function index_activ_structures(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $partners = $partnerRepository->findAll();
        $structures = $structureRepository->findBy(array('isActive' => true));

        $activPartnerLinks = [true, false, false];
        $activStructureLinks = [false, true, false];

        return $this->render('admin/index.html.twig', [
            'admin' => $admin,
            'partners' => $partners,
            'structures' => $structures,
            'activPartnerLinks' => $activPartnerLinks,
            'activStructureLinks' => $activStructureLinks
        ]);
    }

    #[Route('/admin/innactiv-structures', name: 'app_admin_innactiv_structures')]
    public function index_innactiv_structures(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $partners = $partnerRepository->findAll();
        $structures = $structureRepository->findBy(array('isActive' => false));

        $activPartnerLinks = [true, false, false];
        $activStructureLinks = [false, false, true];

        return $this->render('admin/index.html.twig', [
            'admin' => $admin,
            'partners' => $partners,
            'structures' => $structures,
            'activPartnerLinks' => $activPartnerLinks,
            'activStructureLinks' => $activStructureLinks
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
