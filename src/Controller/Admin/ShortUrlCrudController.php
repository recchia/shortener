<?php

namespace App\Controller\Admin;

use App\Entity\ShortUrl;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ShortUrlCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShortUrl::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Shor Url')
            ->setEntityLabelInPlural('Short Urls')
            ->setSearchFields(['longUrl', 'shortUrl'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('longUrl'),
            TextField::new('shortUrl')->onlyOnindex(),
            IntegerField::new('hits')->onlyOnIndex(),
            IntegerField::new('likes')->onlyOnIndex(),
        ];
    }
}
