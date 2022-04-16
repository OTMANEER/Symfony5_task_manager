<?php
/**
 * @author Mohammed MOQRAN 
 */
namespace App\Controller\ProjectManager;

use App\Entity\Task;
use App\Entity\Project;
use App\Entity\ProjectGroup;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class ProjectManagerDashController extends AbstractDashboardController
{
    /**
     * @Route("/ProjectManager2", name="Project_Manager2")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(TaskCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Web Project');
    }

    public function configureMenuItems(): iterable
    {
        
        yield MenuItem::linkToRoute('DashBoard','fa fa-home','Project',['key'=>'/project']);
        
        yield MenuItem::linkToCrud('Tache', 'fas fa-tasks', Task::class);
        yield MenuItem::linkToCrud('Project/Group', 'fas fa-user-friends', ProjectGroup::class);
    }
}
