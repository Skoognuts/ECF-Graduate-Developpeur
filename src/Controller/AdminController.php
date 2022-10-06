<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Partner;
use App\Entity\Structure;
use App\Entity\UserGrants;
use App\Form\NewPartnerType;
use App\Form\NewStructureType;
use App\Form\EditPartnerType;
use App\Form\EditStructureType;
use App\Form\EditStructureWithInnactivPartnerType;
use App\Repository\AdministratorRepository;
use App\Repository\GrantRepository;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use App\Repository\UserRepository;
use App\Repository\UserGrantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/admin/new-partner', name: 'app_admin_new_partner', methods: ['GET', 'POST'])]
    public function admin_new_partner(Request $request, AdministratorRepository $administratorRepository, GrantRepository $grantRepository, PartnerRepository $partnerRepository, UserRepository $userRepository, UserGrantsRepository $userGrantsRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $user = new User();
        $partner = new Partner();

        $globalPermission1 = new UserGrants();
        $globalPermission2 = new UserGrants();
        $globalPermission3 = new UserGrants();
        $globalPermission4 = new UserGrants();
        $globalPermission5 = new UserGrants();

        $form = $this->createForm(NewPartnerType::class, $partner);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEmail($form->get('email')->getData());
            $user->setRoles(["ROLE_PARTNER"]);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $partner->setUserId($user);
            $partner->setCity(strtoupper($form->get('city')->getData()));
            $partner->setIsActive($form->get('isActive')->getData());

            $globalPermission1->setUserId($user);
            $globalPermission2->setUserId($user);
            $globalPermission3->setUserId($user);
            $globalPermission4->setUserId($user);
            $globalPermission5->setUserId($user);

            $globalPermission1->setGrantId($grantRepository->findOneBy(array('id' => 1)));
            $globalPermission2->setGrantId($grantRepository->findOneBy(array('id' => 2)));
            $globalPermission3->setGrantId($grantRepository->findOneBy(array('id' => 3)));
            $globalPermission4->setGrantId($grantRepository->findOneBy(array('id' => 4)));
            $globalPermission5->setGrantId($grantRepository->findOneBy(array('id' => 5)));

            $globalPermission1->setIsActive($form->get('globalPermission1')->getData());
            $globalPermission2->setIsActive($form->get('globalPermission2')->getData());
            $globalPermission3->setIsActive($form->get('globalPermission3')->getData());
            $globalPermission4->setIsActive($form->get('globalPermission4')->getData());
            $globalPermission5->setIsActive($form->get('globalPermission5')->getData());

            $entityManager->persist($user);
            $entityManager->persist($partner);
            $entityManager->persist($globalPermission1);
            $entityManager->persist($globalPermission2);
            $entityManager->persist($globalPermission3);
            $entityManager->persist($globalPermission4);
            $entityManager->persist($globalPermission5);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_created', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new_partner.html.twig', [
            'admin' => $admin,
            'newPartnerForm' => $form->createView()
        ]);
    }

    #[Route('/admin/new-structure', name: 'app_admin_new_structure', methods: ['GET', 'POST'])]
    public function admin_new_structure(Request $request, AdministratorRepository $administratorRepository, GrantRepository $grantRepository, PartnerRepository $partnerRepository, UserRepository $userRepository, UserGrantsRepository $userGrantsRepository, StructureRepository $structureRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $user = new User();
        $structure = new Structure();

        $localPermission1 = new UserGrants();
        $localPermission2 = new UserGrants();
        $localPermission3 = new UserGrants();
        $localPermission4 = new UserGrants();
        $localPermission5 = new UserGrants();

        $form = $this->createForm(NewStructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEmail($form->get('email')->getData());
            $user->setRoles(["ROLE_STRUCTURE"]);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $structure->setUserId($user);
            $partner = $form->get('partnerId')->getData();
            $structure->setPartnerId($partner);
            $structure->setAddress($form->get('address')->getData());
            $structure->setPhone($form->get('phone')->getData());
            $structure->setIsActive($form->get('isActive')->getData());

            $localPermission1->setUserId($user);
            $localPermission2->setUserId($user);
            $localPermission3->setUserId($user);
            $localPermission4->setUserId($user);
            $localPermission5->setUserId($user);

            $localPermission1->setGrantId($grantRepository->findOneBy(array('id' => 1)));
            $localPermission2->setGrantId($grantRepository->findOneBy(array('id' => 2)));
            $localPermission3->setGrantId($grantRepository->findOneBy(array('id' => 3)));
            $localPermission4->setGrantId($grantRepository->findOneBy(array('id' => 4)));
            $localPermission5->setGrantId($grantRepository->findOneBy(array('id' => 5)));

            $localPermission1->setIsActive($partner->getUserId()->getUserGrants()[0]->isIsActive());
            $localPermission2->setIsActive($partner->getUserId()->getUserGrants()[1]->isIsActive());
            $localPermission3->setIsActive($partner->getUserId()->getUserGrants()[2]->isIsActive());
            $localPermission4->setIsActive($partner->getUserId()->getUserGrants()[3]->isIsActive());
            $localPermission5->setIsActive($partner->getUserId()->getUserGrants()[4]->isIsActive());

            $entityManager->persist($user);
            $entityManager->persist($structure);
            $entityManager->persist($localPermission1);
            $entityManager->persist($localPermission2);
            $entityManager->persist($localPermission3);
            $entityManager->persist($localPermission4);
            $entityManager->persist($localPermission5);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_structure_created', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new_structure.html.twig', [
            'admin' => $admin,
            'newStructureForm' => $form->createView()
        ]);
    }

    #[Route('/admin/edit-partner-{id}', name: 'app_admin_edit_partner', methods: ['GET', 'POST'])]
    public function admin_edit_partner(Request $request, AdministratorRepository $administratorRepository, GrantRepository $grantRepository, PartnerRepository $partnerRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));
        $partner = $partnerRepository->findOneBy(array('id' => $id));

        $globalPermissions = $partner->getUserId()->getUserGrants();

        $globalPermission1 = $globalPermissions[0];
        $globalPermission2 = $globalPermissions[1];
        $globalPermission3 = $globalPermissions[2];
        $globalPermission4 = $globalPermissions[3];
        $globalPermission5 = $globalPermissions[4];

        $partnerStructures = $partner->getStructures();

        $form = $this->createForm(EditPartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partner->setIsActive($form->get('isActive')->getData());

            if ($partner->isIsActive() == false) {
                foreach ($partnerStructures as $structure) {
                    $structure->setIsActive(false);
                }
            }

            $globalPermission1->setIsActive($form->get('globalPermission1')->getData());
            $globalPermission2->setIsActive($form->get('globalPermission2')->getData());
            $globalPermission3->setIsActive($form->get('globalPermission3')->getData());
            $globalPermission4->setIsActive($form->get('globalPermission4')->getData());
            $globalPermission5->setIsActive($form->get('globalPermission5')->getData());

            $entityManager->persist($partner);
            $entityManager->persist($globalPermission1);
            $entityManager->persist($globalPermission2);
            $entityManager->persist($globalPermission3);
            $entityManager->persist($globalPermission4);
            $entityManager->persist($globalPermission5);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_edited', ['id' => $partner->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit_partner.html.twig', [
            'admin' => $admin,
            'partner' => $partner,
            'editPartnerForm' => $form->createView()
        ]);
    }

    #[Route('/admin/edit-structure-{id}', name: 'app_admin_edit_structure', methods: ['GET', 'POST'])]
    public function admin_edit_structure(Request $request, AdministratorRepository $administratorRepository, GrantRepository $grantRepository, StructureRepository $structureRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));
        $structure = $structureRepository->findOneBy(array('id' => $id));

        $localPermissions = $structure->getUserId()->getUserGrants();

        $localPermission1 = $localPermissions[0];
        $localPermission2 = $localPermissions[1];
        $localPermission3 = $localPermissions[2];
        $localPermission4 = $localPermissions[3];
        $localPermission5 = $localPermissions[4];

        if ($structure->getPartnerId()->isIsActive() == true) {
            $form = $this->createForm(EditStructureType::class, $structure);
            $form->handleRequest($request);
        } else {
            $form = $this->createForm(EditStructureWithInnactivPartnerType::class, $structure);
            $form->handleRequest($request);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($structure->getPartnerId()->isIsActive() == true) {
                $structure->setIsActive($form->get('isActive')->getData());
                $entityManager->persist($structure);
            } 
            
            $localPermission1->setIsActive($form->get('localPermission1')->getData());
            $localPermission2->setIsActive($form->get('localPermission2')->getData());
            $localPermission3->setIsActive($form->get('localPermission3')->getData());
            $localPermission4->setIsActive($form->get('localPermission4')->getData());
            $localPermission5->setIsActive($form->get('localPermission5')->getData());

            $entityManager->persist($localPermission1);
            $entityManager->persist($localPermission2);
            $entityManager->persist($localPermission3);
            $entityManager->persist($localPermission4);
            $entityManager->persist($localPermission5);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_structure_edited', ['id' => $structure->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit_structure.html.twig', [
            'admin' => $admin,
            'structure' => $structure,
            'editStructureForm' => $form->createView()
        ]);
    }

    #[Route('/admin/partner_created', name: 'app_admin_partner_created')]
    public function partner_created(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, MailerInterface $mailer): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $lastPartner = $partnerRepository->findOneBy(array(), array('id' => 'DESC'));

        $this->sendEmail(
            $mailer,
            $lastPartner->getUserId()->getEmail(),
            'SPORTY : Votre compte partenaire a été créé !!!',
            'Cher partenaire de ' . $lastPartner->getCity() . ', votre compte à bien été créé. Nous vous invitons à vous connecter sur votre Espace Partenaire avec les identifiants que vous avez reçu par courrier postal. Cordialement, Jean BOMBEUR.'
        );

        return $this->render('admin/partner_created.html.twig', [
            'admin' => $admin,
            'partner' => $lastPartner
        ]);
    }

    #[Route('/admin/structure_created', name: 'app_admin_structure_created')]
    public function structure_created(AdministratorRepository $administratorRepository, StructureRepository $structureRepository, MailerInterface $mailer): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $lastStructure = $structureRepository->findOneBy(array(), array('id' => 'DESC'));

        $this->sendEmail(
            $mailer,
            $lastStructure->getUserId()->getEmail(),
            'SPORTY : Votre compte structure a été créé !!!',
            'Cher gérant de la succursale de l\'adresse ' . $lastStructure->getAddress() . ' affiliée au partenaire ' . $lastStructure->getPartnerId()->getCity() . ', votre compte à bien été créé. Nous vous invitons à vous connecter sur votre Espace Succursale avec les identifiants que vous avez reçu par courrier postal. Cordialement, Jean BOMBEUR.'
        );

        return $this->render('admin/structure_created.html.twig', [
            'admin' => $admin,
            'structure' => $lastStructure
        ]);
    }

    #[Route('/admin/partner_edited-{id}', name: 'app_admin_partner_edited')]
    public function partner_edited(AdministratorRepository $administratorRepository, PartnerRepository $partnerRepository, int $id, MailerInterface $mailer): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $partner = $partnerRepository->findOneBy(array('id' => $id));

        $this->sendEmail(
            $mailer,
            $partner->getUserId()->getEmail(),
            'SPORTY : Votre compte partenaire a été modifié !!!',
            'Cher partenaire de ' . $partner->getCity() . ', votre compte à été modifié. Nous vous invitons à vous connecter sur votre Espace Partenaire avec les identifiants que vous avez reçu par courrier postal. Cordialement, Jean BOMBEUR.'
        );

        return $this->render('admin/partner_edited.html.twig', [
            'admin' => $admin,
            'partner' => $partner
        ]);
    }

    #[Route('/admin/structure_edited-{id}', name: 'app_admin_structure_edited')]
    public function structure_edited(AdministratorRepository $administratorRepository, StructureRepository $structureRepository, int $id, MailerInterface $mailer): Response
    {
        $currentUser = $this->getUser();
        $admin = $administratorRepository->findOneBy(array('userId' => $currentUser->getId()));

        $structure = $structureRepository->findOneBy(array('id' => $id));

        $this->sendEmail(
            $mailer,
            $structure->getUserId()->getEmail(),
            'SPORTY : Votre compte structure a été modifié !!!',
            'Cher gérant de la succursale de l\'adresse ' . $structure->getAddress() . ' affiliée au partenaire ' . $structure->getPartnerId()->getCity() . ', votre compte à été modifié. Nous vous invitons à vous connecter sur votre Espace Succursale avec les identifiants que vous avez reçu par courrier postal. Cordialement, Jean BOMBEUR.'
        );

        return $this->render('admin/structure_edited.html.twig', [
            'admin' => $admin,
            'structure' => $structure
        ]);
    }

    public function sendEmail(MailerInterface $mailer, string $sendTo, string $subject, string $text): void
    {
        $email = (new Email())
            ->from('j.labatut1987@gmail.com')
            ->to($sendTo)
            ->subject($subject)
            ->text($text);

        $mailer->send($email);
    }

    public function searchPartner(Request $request, PartnerRepository $partnerRepository, EntityManagerInterface $em): Response
    {
        $requestedPartner = $request->get('searchPartnerQuery');
        $partners = $partnerRepository->findByCity($requestedPartner);

        if (!$partners) {
            $result['partners']['error'] = 'Aucun partenaire trouvé';
        } else {
            $result['partners'] = $this->getPartners($partners);
        }

        return new Response(json_encode($result));
    }

    public function getPartners($partners){

        foreach ($partners as $partner){
            $realPartners[$partner->getId()] = $partner->getCity();
        }
  
        return $realPartners;
    }
}
