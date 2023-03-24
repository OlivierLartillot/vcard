<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\GmapLocalisation;
use App\Entity\Social;
use App\Entity\User;
use App\Entity\UserSocial;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
       // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Vcard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Réseaux Sociaux', 'fas fa-list', Social::class)->setPermission('ROLE_ADMIN');

        if ($this->isGranted('ROLE_COMPANY') or $this->isGranted('ROLE_PERSON')) {
            yield MenuItem::linkToCrud('Mes réseaux', 'fas fa-list', UserSocial::class); 
        }

        yield MenuItem::subMenu('Company', 'fa-solid fa-shop')
            ->setPermission('ROLE_COMPANY')
            ->setSubItems([
                MenuItem::linkToCrud('Informations', 'fas fa-list', Company::class)->setPermission('ROLE_COMPANY'),
                MenuItem::linkToCrud('Localisation', 'fas fa-list', GmapLocalisation::class)->setPermission('ROLE_COMPANY'),
          
            ]);
        yield MenuItem::linkToCrud('Personnals Informations', 'fas fa-list', Company::class)->setPermission('ROLE_PERSON');



        yield MenuItem::linkToRoute('Gmap TEST', 'fas fa-list', 'app_admin_gmap', []);
     
    }
}
