<?php
/**
 * @author Mohammed MOQRAN 
 */
namespace App\Controller;

use App\Entity\User;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class ProjectManagerController extends AbstractDashboardController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
        
    }
     
    public function index(): Response
    {
        $repoUser=$this->em->getRepository(User::class);
        $pm=$repoUser->findOneBy(array('id'=>1));
        $repoProject=$this->em->getRepository(Project::class);
        $projects=$repoProject->findOneBy(array('managerId'=>$pm->getId()));
        return $this->render('project_manager/EasyAdmin/welcome.html.twig', [
            'controller_name' => 'ProjectManagerController', 'projects'=>$projects,'manager'=>$pm
        ]);
    }
}
