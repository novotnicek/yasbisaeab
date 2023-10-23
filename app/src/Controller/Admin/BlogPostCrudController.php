<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BlogPostCrudController extends AbstractCrudController
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
    ) {}

    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setEntityLabelInSingular(
                fn (?BlogPost $p, ?string $pageName) => $p ? $p->__toString() : null
            )
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('title')
            ->setColumns(8)
            ->setFormTypeOptions(['row_attr' => ['data-controller' => 'emojiField']]);

        yield AssociationField::new('author')
            ->hideOnForm();

        yield DateTimeField::new('publishedAt')
            ->setColumns(4);

        yield SlugField::new('slug')
            ->hideOnIndex()
            ->setColumns(8)
            ->setTargetFieldName('title');

        yield TextareaField::new('description')
            ->hideOnIndex()
            ->setColumns(4);

        yield TextareaField::new('content')
            ->addCssClass('trumbowygInit')
            ->onlyOnForms()
            ->setColumns(12);
    }

    public function createEntity(string $entityFqcn): BlogPost
    {
        $blogPost = new BlogPost();
        $blogPost->setAuthor($this->tokenStorage->getToken()->getUser());
        $blogPost->setCreatedAt(new \DateTimeImmutable());

        return $blogPost;
    }
}
