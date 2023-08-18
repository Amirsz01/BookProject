<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\Category;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:books:parse',
    description: 'Add a short description for your command',
)]
class BooksParseCommand extends Command
{

    const DEFAULT_CATEGORY_TITLE = 'Новинки';

    public function __construct(
        private readonly HttpClientInterface    $client,
        private readonly EntityManagerInterface $em,
    )
    {
        parent::__construct();
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $response = $this->client->request(
            'GET',
            $_ENV['PARSING_URL']
        );

        $books = $response->toArray();

        foreach ($books as $bookData) {
            if ($this->isHasBook($bookData['title'])) {
                continue;
            }
            $book = new Book();
            $book->setTitle($bookData['title']);
            if (!isset($bookData['isbn'])) {
                continue;
            }
            $book->setIsbn($bookData['isbn']);
            if (isset($bookData['thumbnailUrl'])) {
                $book->setThumbnailUrl($bookData['thumbnailUrl']);
            }
            $book->setPageCount($bookData['pageCount']);
            $book->setStatus($bookData['status']);
            $book->setAuthors($bookData['authors']);

            $category = $this->getCategory($bookData['categories']);
            $book->setCategory($category);
            if (isset($bookData['publishedDate'])) {
                $book->setPublishedDate(new Datetime($bookData['publishedDate']['$date']));
            }
            $this->em->persist($book);
            $this->em->flush();
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }

    public function getCategory(array $categories): Category
    {
        if (empty($categories)) {
            $title = self::DEFAULT_CATEGORY_TITLE;
        } else {
            $title = array_pop($categories);
        }
        $category = $this->em->getRepository(Category::class)
            ->findOneBy(['title' => $title]);

        if (is_null($category)) {
            $category = new Category();
            $category->setTitle($title);
            $this->em->persist($category);

            if (!empty($categories)) {
                $parentCategory = $this->getCategory($categories);
                $category->setParent($parentCategory);
            }
        }

        return $category;
    }

    public function isHasBook(string $title): bool
    {
        return (bool)$this->em->getRepository(Book::class)
            ->findOneBy(['title' => $title]);
    }
}
