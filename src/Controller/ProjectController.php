<?php
/**
 * @author Mohamed BENYAGOUB
 */
namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'Project')]
    public function index(Request $request): Response
    {
        $me = $this->getUser();
        $manager = $this->get("doctrine")->getManager();
        
        if ($request->getMethod()=="GET") {
            $projects = $manager->getRepository(Project::class)->findAll();
        }
        else{
            if(!is_null($request->request->get("name"))){
                switch ($request->request->get("searchBy")) {
                    case 'manager':
                        $query = $manager->getRepository(Project::class)
                            ->createQueryBuilder('project')
                            ->innerJoin(User::class, 'user', 'WITH', 'project.managerId = user.id')
                            ->where('user.name LIKE :username ')
                            ->setParameter("username", "%".$request->request->get("name")."%")
                        ;                    
                    break;
                    case 'project':
                        $query = $manager->getRepository(Project::class)
                            ->createQueryBuilder('project')
                            ->where("project.title LIKE :title")
                            ->setParameter("title", "%".$request->request->get("name")."%")
                        ;
                    break;
                    case 'task':
                        $query = $manager->getRepository(Project::class)
                            ->createQueryBuilder('project')
                            ->innerJoin(Task::class, 'task', 'WITH', 'project.id = task.projectId')
                            ->where("task.title LIKE :title")
                            ->setParameter("title", "%".$request->request->get("name")."%")
                        ;                    
                    break;
                    
                }
            }

            if($request->request->get("dateDebut") != false){
                $query
                    ->andWhere("project.dateInit >= :dateDebut")
                    ->setParameter("dateDebut", $request->request->get("dateDebut"))
                ;
            }

            if($request->request->get("dateFin") != false ){
                $query
                    ->andWhere("project.dateInit <= :dateFin")
                    ->setParameter("dateFin", $request->request->get("dateFin"))
                ;
            }

            if(!is_null($request->request->get("orderBy"))){
                switch ($request->request->get("orderBy")) {
                    case 'dateAsc':
                        $query->orderBy("project.dateInit", "asc");
                        break;

                    case 'dateDesc':
                        $query->orderBy("project.dateInit", "desc");
                        break;

                    case 'alphaAsc':

                        switch ($request->request->get("searchBy")) {
                            case 'manager':
                                $query->orderBy("user.name", "asc");
                                ;                    
                            break;
                            case 'project':
                                $query->orderBy("project.title", "asc");
                            break;
                            case 'task':
                                $query->orderBy("task.title", "asc");          
                            break;
                        }
                        break;

                    case 'alphaDesc':
                        switch ($request->request->get("searchBy")) {
                            case 'manager':
                                $query->orderBy("user.name", "desc");
                                ;                    
                            break;
                            case 'project':
                                $query->orderBy("project.title", "desc");
                            break;
                            case 'task':
                                $query->orderBy("task.title", "desc");          
                            break;
                        } 
                        break;                    
                }


            }



            $projects = $query
                ->getQuery()
                ->getResult()
            ;
        }


        $users = $manager->getRepository(User::class)->findAll();

        return $this->render("projectView.twig", [
            'projects' => $projects,
            'users' => $users,
            'name' => $request->request->get("name"),
            'currentUser' => $me
        ]);
    }
}
