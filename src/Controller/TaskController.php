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
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends AbstractController
{

    #[Route('/task', name: 'Task')]
    public function index(): Response
    {
        $me = $this->getUser();
        $manager = $this->get("doctrine")->getManager();

        $tasks =    $manager->getRepository(Task::class)
                        ->createQueryBuilder('task')
                        ->where('task.userId = :User')
                        ->setParameter("User", $me)
                        ->getQuery()
                        ->getResult()
                    ;

        return $this->render("taskView.twig",['tasks' => $tasks]);
    }

    #[Route('/task/{id}', name: 'getTaskAPI')]
    public function sendResponse(Request $request, int $id)    
    {
        
        if ($request->isXMLHttpRequest()) {  

            $manager = $this->get("doctrine")->getManager();
    
            $task = $manager->getRepository(Task::class)
                ->createQueryBuilder('task')
                ->where("task.id = :id")
                ->setParameter("id", $id)
                ->getQuery()
                ->getResult()
            ;
            $task[0]->setDone(!$task[0]->getDone());
            if($task[0]->getDone()){
                $task[0]->setDateFin(new \DateTime());
            }
            else{
                $task[0]->setDateFin(null);
            }
            $manager->persist($task[0]);
            $manager->flush();

            $resp = $manager->getRepository(Task::class)
                ->findBy(
                    array(
                    'projectId' => $task[0]->getProjectId()->getId(),
                    'done' => false
                )
            );

            if(count($resp) == 0){ 
                $task[0]->getProjectId()->setDateFin(new \DateTime());
            }else{
                $task[0]->getProjectId()->setDateFin(null);
            }
            $manager->persist($task[0]);
            $manager->flush();
            


            return new JsonResponse(
                array(
                    "etatTask" => $task[0]->getDone(),
                    "cond" => (count($resp) == 0),
                    "id" => $task[0]->getProjectId()->getId(),
                    "date" => date('d/m/Y')

                )
            );
        }
    
        return new Response('Bad Redirection', 400);
    }



}