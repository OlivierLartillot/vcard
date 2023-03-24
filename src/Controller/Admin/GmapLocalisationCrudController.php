<?php

namespace App\Controller\Admin;

use App\Entity\GmapLocalisation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GmapLocalisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GmapLocalisation::class;
    }


    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addCssFile('css/admin.css');

            
    }


    
    public function configureFields(string $pageName): iterable
    {

            return [
                    IdField::new('id'),
                    TextField::new('latitude'),
                    TextField::new('longitude'),
                ];

    }
   
}
