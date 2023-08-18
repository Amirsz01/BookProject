<?php

namespace App\Controller;

use App\Entity\Category;
use App\Service\BookService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    public function __construct(
        private readonly BookService            $bookService,
        private readonly EntityManagerInterface $em,
    )
    {
    }

    #[Route('', name: 'app_index')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $this->em->getRepository(Category::class)->getMainCategories();

        return $this->render('index/index.html.twig', [
            'categories' => $categories
        ]);
    }
    #[Route('/category/{!id}', name: 'app_index_category')]
    public function showByCategory(Category $category, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $category->getCategories();

        $query = $this->bookService->getBooksQuery($category->getId());

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), $_ENV['PER_PAGE']);

        return $this->render('index/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories
        ]);
    }
}
