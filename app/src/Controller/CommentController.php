<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use App\Form\BlogPostCommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    #[Route('/comment/add/{blogPostId}', name: 'app_comment_new')]
    public function new(int $blogPostId, Request $request): Response
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->em->getRepository(BlogPost::class)->find($blogPostId);
        if (!$blogPost || $blogPost->getPublishedAt() > new \DateTimeImmutable()) {
            return $this->createAccessDeniedException();
        }

        $form = $this->createForm(BlogPostCommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var BlogPostComment $comment */
            $comment = $form->getData();
            $comment->setBlogPost($blogPost);
            $comment->setCreatedAt(new \DateTimeImmutable());

            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('app_blog_post', ['blogPostId' => $blogPostId]);
        }

        return $this->render('comment/add.html.twig', [
            'form' => $form->createView(),
            'post' => $blogPost,
        ]);
    }
}
