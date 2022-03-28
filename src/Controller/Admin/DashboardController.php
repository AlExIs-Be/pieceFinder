<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Component;
use App\Entity\GameContent;
use App\Entity\ComponentType;
use App\Controller\Admin\AuthorCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(AuthorCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Piecefinder')
            ->setFaviconPath('image/logoPF.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Dashboard', 'fa fa-cog');
        yield MenuItem::linkToCrud('Catégories', 'fa fa-folder-open', Category::class);
        yield MenuItem::linkToCrud('Auteurs', 'fa fa-user', Author::class);
        yield MenuItem::linkToCrud('Jeux', 'fa fa-puzzle-piece', Game::class);
        yield MenuItem::linkToCrud('Contenus', 'fa fa-chess-rook', GameContent::class);
        yield MenuItem::linkToCrud('Pièces', 'fa fa-chess-rook', Component::class);
        yield MenuItem::linkToCrud('Types', 'fa fa-cog', ComponentType::class);
        yield MenuItem::linkToRoute('Retour à l\'accueil', 'fa fa-home', "home");
    }
}
