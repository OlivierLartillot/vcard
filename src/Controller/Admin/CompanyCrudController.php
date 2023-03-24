<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Query\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection as CollectionFilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractCrudController
{
    
    private $userRepository;
    private $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, CollectionFilterCollection $filters): QueryBuilder
    {
        $user = $this->getUser();
        
        $qb = $this->companyRepository->createQueryBuilder('c');
        if (!in_array("ROLE_ADMIN", $user->getRoles())) {
            $qb->where('c.user = :user')
            ->setParameter('user', $user);
        }
        return $qb;
    }

    public function createEntity(string $entityFqcn)
    {

        $user = $this->userRepository->find($this->getUser());
        $company = new Company();
        $company->setUser($user);

        return $company;
    }


    
/*     public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Company Name'),
            TextField::new('firstname', 'Firstname'),
            TextField::new('Lastname', 'Lastname'),
            AssociationField::new('user')->hideOnForm(),
        ];
    } */
    
}
