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
        $categories = $this->em->getRepository(Category::class)->findBy(['parent' => $request->get('category')]);

        $query = $this->bookService->getBooksQuery($request->get('category'));

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('index/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories
        ]);
    }
}
