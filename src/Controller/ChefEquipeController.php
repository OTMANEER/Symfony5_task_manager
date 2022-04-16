<?php
/**
 * @author Otmane ER-RAGRAGUI
 */
namespace App\Controller;

use App\Entity\Group;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use App\Form\chefEquipeForm;
use App\Repository\GroupRepository;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Builder\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Twig\Environment;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChefEquipeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/chefEquipe', name: 'chefEquipe')]
    public function index(Request $request, ProjectRepository $projectRepository, UserRepository $userRepository, TaskRepository $taskRepository, GroupRepository $groupRepository, EntityManagerInterface $em): Response
    {
        $idUser = $this->getUser()->getId();

        $head = $userRepository->find($idUser);
        $projects = $projectRepository->findBy(['managerId' => $idUser]);
        $members = $userRepository->findBy(['groupId' => $head->getGroupId()]);

        $temp = 0;

        foreach ($members as $m) {
            foreach ($m->getRoles() as $roles)
                if ($roles == 'ROLE_EQUIPE_CHEF' ||$roles == 'ROLE_ADMIN' || $roles == 'ROLE_PROJECT_CHEF' )
                    unset($members[$temp]);
            //  dd($temp);
            $temp++;
        }



        $form = $this->createFormBuilder()
            ->add('Project', EntityType::class, [
                'placeholder' => 'Please choose a Project',
                'constraints' => new NotBlank(['message' => 'Please Choose a Project  😯']),
                'class' => Project::class,
                'choices' => $projects,
                'query_builder' => function (ProjectRepository $projectRepository) {
                    return $projectRepository->createQueryBuilder('c')
                        //->where('c.manager_id_id = idUser')
                        ->orderBy('c.deadline', 'ASC');
                }

            ])
            ->add('Task', EntityType::class, [
                'placeholder' => 'Please choose a Task',
                'constraints' => new NotBlank(['message' => 'Please Choose a Task  😯']),
                'class' => Task::class,
                'query_builder' => function (TaskRepository $taskRepository) {
                    return $taskRepository->createQueryBuilder('c')->orderBy('c.deadline', 'ASC');
                }
            ])
            ->add('User', EntityType::class, [
                'placeholder' => 'Please choose a Member',
                'constraints' => new NotBlank(['message' => 'Please Choose a Member 😯']),
                'class' => User::class,
                'choices' => $members,
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                }
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $final = $form->get('Task')->getData();
            $taskBeforeUpdate = $taskRepository->find($final->getId());
            $taskBeforeUpdate->setUserId($form->get('User')->getData(['id']));

            // dd($taskBeforeUpdate,$theUser);
            $em->persist($taskBeforeUpdate);
            $em->flush();
            $this->addFlash(
                'info',
                'Added Successfully'
            );

        }

        return $this->render('chef_equipe/index.html.twig', ['projects' => $projectRepository->findAll(),
            'myForm' => $form->createView(),
            'head' => $head
        ]);
    }


    #[Route('/chefEquipe/addMembers', name: 'addMembers')]
    public function addMemebers(Request $request, ProjectRepository $projectRepository, UserRepository $userRepository, TaskRepository $taskRepository, GroupRepository $groupRepository, EntityManagerInterface $em): Response
    {
        $idUser = $this->getUser()->getId();

        $head = $userRepository->find($idUser);
        $projects = $projectRepository->findBy(['managerId' => $idUser]);
        $members = $userRepository->findAll();

        $groupsOfThisChef = $groupRepository->findBy(['id' => $head->getGroupId()]);

        $temp = 0;
        foreach ($members as $m) {
            foreach ($m->getRoles() as $roles)
                if ($roles == 'ROLE_EQUIPE_CHEF' ||$roles == 'ROLE_ADMIN' || $roles == 'ROLE_PROJECT_CHEF' )
                    unset($members[$temp]);
            $temp++;
        }


        $form = $this->createFormBuilder()
            ->add('Members', EntityType::class, [
                'placeholder' => 'Please choose a Member',
                'constraints' => new NotBlank(['message' => 'Please Choose a Member  😯']),
                'class' => User::class,
                'choices' => $members,
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->createQueryBuilder('c')->orderBy('c.prenom', 'ASC');
                }
            ])
            ->add('Groups', EntityType::class, [
                'placeholder' => 'Please choose a Member',
                'constraints' => new NotBlank(['message' => 'Please Choose a GROUP  😯']),
                'class' => Group::class,
                'choices' => $groupsOfThisChef
            ])
            ->getForm();


// add flash messages

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->get('Members')->getData();
            $group = $form->get('Groups')->getData();
            //  dd($group,$user);
            $user->setGroupId($form->get('Groups')->getData(['id']));
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'info',
                'Added Successfully'
            );
        }


        return $this->render('chef_equipe/addMembers.html.twig', ['projects' => $projectRepository->findAll(),
            'myForm' => $form->createView(),
            'head' => $head
        ]);
    }


    private function addTaskField(FormInterface $form, Project $project)
    {
        $builder = $form->getParent()->getConfig()->getFormFactory()->createNamedBuilder(
            'Task',
            EntityType::class,
            null,
            [
                'placeholder' => 'Please choose a Task',
                'constraints' => new NotBlank(['message' => 'Please Choose a Task  😯']),
                'class' => Task::class,
                'auto_initialize' => false,
                'choices' => $project->getTasks(),
                'query_builder' => function (TaskRepository $taskRepository) {
                    return $taskRepository->createQueryBuilder('c')->orderBy('c.deadline', 'ASC');
                }
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {

            }
        );
        $form->add($builder->getForm());

    }

}