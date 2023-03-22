<?php

namespace App\Controller\Admin;

use App\Entity\UserSocial;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;

class UserSocialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserSocial::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('social','Réseau'),
            AssociationField::new('user','Utilisateur'),
            TextField::new('link'),
            BooleanField::new('published'),
            IntegerField::new('appearanceOrder'),
        ];
    }
   
}
