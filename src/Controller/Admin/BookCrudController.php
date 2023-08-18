<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('isbn'),
            NumberField::new('pageCount'),
            DateField::new('publishedDate'),
            ImageField::new('thumbnail_url')
                ->setUploadDir('public/images/')
                ->setBasePath('images/')
                ->setUploadedFileNamePattern('[uuid].[extension]'),
            TextField::new('status'),
            ArrayField::new('authors'),
            AssociationField::new('category'),
        ];
    }
}
