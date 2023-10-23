<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
    ) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->redirect(
            $this->adminUrlGenerator->setController(BlogPostCrudController::class)->generateUrl()
        );
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addWebpackEncoreEntry('ea');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('YasbiSaEAB');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Homepage', 'fa fa-home', 'app_blog_index');
        yield MenuItem::linkToCrud('Blog posts', 'fa fa-file', BlogPost::class);
        yield MenuItem::linkToCrud('Comments', 'fa fa-comments', BlogPostComment::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
    }
}
