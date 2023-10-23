<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Model\Enum\UserRoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield EmailField::new('email');
        yield TextField::new('password')->hideOnIndex();
        yield ChoiceField::new('roles')
            ->setChoices(UserRoleEnum::getChoices())
            ->allowMultipleChoices();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setEntityLabelInSingular(
                fn (?User $u, ?string $pageName) => $u ? $u->__toString() : null
            )
        ;
    }

    public function persistEntity(EntityManagerInterface $em, $entity): void
    {
        $hash = $this->passwordHasher->hashPassword($entity, $entity->getPassword());
        $entity->setPassword($hash);

        $em->persist($entity);
        $em->flush();
    }

    public function updateEntity(EntityManagerInterface $em, $entity): void
    {
        $hash = $this->passwordHasher->hashPassword($entity, $entity->getPassword());
        $entity->setPassword($hash);

        $em->persist($entity);
        $em->flush();
    }
}
