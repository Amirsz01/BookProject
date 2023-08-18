<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class BookService
{

    public function __construct(
        private readonly EntityManagerInterface $em,
    )
    {
    }

    public function getBooksQuery(?int $categoryId): Query
    {
        return $this->em->getRepository(Book::class)
            ->createQueryBuilder('b')
            ->addSelect('c')
            ->leftJoin('b.category', 'c')
            ->where('c.id = :category OR c.parent = :category')
            ->setParameter('category', $categoryId)
            ->getQuery();
    }
}
