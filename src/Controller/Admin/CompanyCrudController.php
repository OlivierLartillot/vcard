<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    
    public function configureFields(string $pageName): iterable
    {

        $package = new Package(new EmptyVersionStrategy());

        // gestion local en env dev ou ligne prod

        if ($_ENV['APP_ENV']  == 'dev' ){
            $uploadPath = $package->getUrl('public\images\logos\\');  
        } else{
            $uploadPath = $package->getUrl('public/images/logos/');  
        }

        $path = $package->getUrl('/assets/images/logos/');

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            TextField::new('name'),
            ImageField::new('logo')->setUploadDir($uploadPath)->setBasePath($path)->setHelp('<ul><li>Une image carrée rendra mieux qu\'une image trop large ou trop haute ! </li><li>supprimer l\'image la supprimera définitivement</li></ul>'),
            //AssociationField::new('user'),
        ];
    }
    
}
