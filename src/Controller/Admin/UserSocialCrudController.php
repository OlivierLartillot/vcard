<?php

namespace App\Controller\Admin;

use App\Entity\UserSocial;
use App\Repository\UserRepository;
use App\Repository\UserSocialRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class UserSocialCrudController extends AbstractCrudController
{

    private $userRepository;
    private $userSocialRepository;
 

    public function __construct(UserRepository $userRepository, UserSocialRepository $userSocialRepository)
    {
        $this->userRepository = $userRepository;
        $this->userSocialRepository = $userSocialRepository;
    }

    public static function getEntityFqcn(): string
    {
        return UserSocial::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        
        $user = $this->getUser();
        
        $qb = $this->userSocialRepository->createQueryBuilder('u_s');
        if (!in_array("ROLE_ADMIN", $user->getRoles())) {
            $qb->where('u_s.user = :user')
            ->setParameter('user', $user);
        }
        return $qb;
    }

    public function createEntity(string $entityFqcn)
    {
        // regarde combien tu en as créé pour mettre un ordre de base
        $userSocials = count($this->userSocialRepository->findBy(['user' => $this->getUser()]));
        $indexUserSocials = $userSocials+1;

        $user = $this->userRepository->find($this->getUser());
        $userSocial = new UserSocial();
        $userSocial->setUser($user);
        $userSocial->setAppearanceOrder($indexUserSocials);

        return $userSocial;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user')->hideOnForm(),
            AssociationField::new('social'),
            TextField::new('link'),
            BooleanField::new('published'),
            IntegerField::new('appearanceOrder'),
        ]; 
    }

}
