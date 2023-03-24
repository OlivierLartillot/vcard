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
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

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


    
    public function configureFields(string $pageName): iterable
    {
        $package = new Package(new EmptyVersionStrategy());
        if ($_ENV['APP_ENV']  == 'dev' ){
            $uploadPath = $package->getUrl('public\images\logos\\');  
        } else{
            $uploadPath = $package->getUrl('public/images/logos/');  
        }

        $path = $package->getUrl('/images/logos/');


        if ( (in_array( "ROLE_ADMIN" ,$this->getUser()->getRoles())) or (in_array( "ROLE_COMPANY" ,$this->getUser()->getRoles())) ){

            return [

                //--------- Add a tab ---------
                FormField::addTab('Basic information'),
                //--------- Fields ---------
                IdField::new('id')->hideOnForm(),
                TextField::new('name', 'Company Name'),
                TextField::new('firstname', 'Firstname'),
                TextField::new('lastname', 'Lastname'),
                ImageField::new('logo', 'Logo')->setUploadDir($uploadPath)->setBasePath($path),
                TelephoneField::new('phoneNumber','Phone Number'),
                EmailField::new('email','Email'),
                //--------- Add a tab ---------
                FormField::addTab('Other Information'),
                //--------- Fields ---------
                UrlField::new('website', 'Website'),
                TextField::new('address', 'Address'),
                ImageField::new('otherMedia', 'Other Media')->setUploadDir($uploadPath)->setBasePath($path),
                //--------- Automatic Fields  ---------
                AssociationField::new('user')->hideOnForm(),
            ];

        }
        else {
            return [

                //--------- Add a tab ---------
                FormField::addTab('Basic information'),
                //--------- Fields ---------
                IdField::new('id')->hideOnForm(),
                TextField::new('firstname', 'Firstname'),
                TextField::new('lastname', 'Lastname'),
                ImageField::new('logo', 'Avatar')->setUploadDir($uploadPath)->setBasePath($path),
                TelephoneField::new('phoneNumber','Phone Number'),
                EmailField::new('email','Email'),
                //--------- Add a tab ---------
                FormField::addTab('Other Information'),
                 //--------- Fields ---------
                UrlField::new('website', 'Website'),
                ImageField::new('otherMedia', 'Other Media')->setUploadDir($uploadPath)->setBasePath($path),
                //--------- Automatic Fields  ---------
                AssociationField::new('user')->hideOnForm(),
            ];

        }
   
    }
    
}
