<?php
/**
* @author Sami DAHMANI
*/
namespace App\Controller\Admin;
use App\Entity\User;
use App\Entity\Group;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]

    public function index(): Response
    {
    $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    
}
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')
                  ->setFaviconPath('favicon.svg')

                  // the domain used by default is 'messages'
                  ->setTranslationDomain('my-custom-domain')
    
                  ->setTextDirection('ltr')
      
                  // set this option if you prefer the page content to span the entire
                  // browser width, instead of the default design which sets a max width
                  ->renderContentMaximized()
      
                  // set this option if you prefer the sidebar (which contains the main menu)
                  // to be displayed as a narrow column instead of the default expanded design
                  ->renderSidebarMinimized()
      
                  // by default, all backend URLs include a signature hash. If a user changes any
                  // query parameter (to "hack" the backend) the signature won't match and EasyAdmin
                  // triggers an error. If this causes any issue in your backend, call this method
                  // to disable this feature and remove all URL signature checks
                  ->disableUrlSignatures()
      
                  // by default, all backend URLs are generated as absolute URLs. If you
                  // need to generate relative URLs instead, call this method
                  ->generateRelativeUrls()
              ;
          }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('DashBoard','fa fa-home','Project',['key'=>'/project']);
        yield MenuItem::linkToCrud('User', 'fas fa-user-plus', User::class);
        yield MenuItem::linkToCrud('Group', 'fa fa-users', Group::class);
         yield MenuItem::linkToCrud('Project', 'fas fa-project-diagram', Project::class);
    }
}
