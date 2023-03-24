<?php

namespace App\Controller\Admin;

use App\Entity\GmapLocalisation;
use App\Repository\GmapLocalisationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GmapController extends AbstractController
{

    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }


    #[Route('/admin/gmap', name: 'app_admin_gmap', methods: ['GET', 'POST'])]
    public function index(HttpFoundationRequest $request, GmapLocalisationRepository $gmapLocalisationRepository): Response
    {


    
        $gmap = $gmapLocalisationRepository->findOneBy(['user' => $this->getUser()]);

        $latEnBdd = ($gmap and $gmap->getLatitude() != null) ? $gmap->getLatitude() : null ;
        $lngEnBdd = ($gmap and $gmap->getLongitude() != null) ? $gmap->getLongitude() : null ;
        
        
        if ( (!empty($_POST)) and (is_numeric($request->request->get('lat'))) and (is_numeric($request->request->get('lng'))) ) {
            
            
            
            // Si existe on update gmap
            if ($gmap) {
                
                $gmap->setLatitude($request->request->get('lat'));
                $gmap->setLongitude($request->request->get('lng'));
                $gmapLocalisationRepository->save($gmap, true);

                $url = $this->adminUrlGenerator->setRoute('app_admin_gmap', [])->generateUrl();


                return $this->redirect($url);
            } 
            // sinon on créé gmap et on le lie a la company 
            else {
                $gmap = new GmapLocalisation();

                $gmap->setLatitude($request->request->get('lat'));
                $gmap->setLongitude($request->request->get('lng'));
                $gmap->setUser($this->getUser());

                $gmapLocalisationRepository->save($gmap, true);

                $url = $this->adminUrlGenerator->setRoute('app_admin_gmap', [])->generateUrl();


                return $this->redirect($url);
            }


        }
       

        return $this->render('admin/gmap/index.html.twig', [
            'latEnBdd' => $latEnBdd,
            'lngEnBdd' => $lngEnBdd
        ]);
    }
}
