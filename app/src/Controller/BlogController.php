<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use App\Model\Paginator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private const POSTS_PER_PAGE = 2;

    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    #[Route('/', name: 'app_blog_index')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'posts' => $this->em->getRepository(BlogPost::class)->matching($this->getCriteriaBy()),
            'paginator' => $this->getPaginator(),
        ]);
    }

    #[Route('/archive/{currentPage}', name: 'app_blog_archive')]
    public function archive(int $currentPage): Response
    {
        return $this->render('blog/index.html.twig', [
            'posts' => $this->em->getRepository(BlogPost::class)->matching($this->getCriteriaBy($currentPage)),
            'paginator' => $this->getPaginator($currentPage),
        ]);
    }

    #[Route('/post/{blogPostId}', name: 'app_blog_post')]
    public function blogPosts(int $blogPostId): Response
    {
        return $this->render('blog/post.html.twig', [
            'post' => $this->em->getRepository(BlogPost::class)->find($blogPostId),
        ]);
    }

    private function getCriteria(): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->lt('publishedAt', new \DateTimeImmutable()))
            ->orderBy(['publishedAt' => 'DESC']);
    }

    private function getCriteriaBy(int $currentPage = 1): Criteria
    {
        return $this->getCriteria()
            ->setMaxResults(self::POSTS_PER_PAGE)
            ->setFirstResult(($currentPage - 1)* self::POSTS_PER_PAGE);
    }

    private function getPaginator(int $currentPage = 1): Paginator
    {
        return (new Paginator())
            ->setItemsPerPage(self::POSTS_PER_PAGE)
            ->setItems($this->em->getRepository(BlogPost::class)->matching($this->getCriteria())->count())
            ->setCurrentPage($currentPage);
    }
}
