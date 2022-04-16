<?php
/**
 * @author Mohammed MOQRAN 
 */
namespace App\Controller\ProjectManager;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Group;
use App\Entity\Project;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TaskCrudController extends AbstractCrudController
{
    



    private $em,$requestStack;
    public function __construct(EntityManagerInterface $em,RequestStack $requestStack)
    {
        $this->em=$em;
        $this->requestStack = $requestStack;
        $repoTask = $this->em->getRepository(Task::class);
    }
    public static function getEntityFqcn(): string
    {
       
        return Task::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $session=$this->requestStack->getSession();
        $managerName=$session->get('username');

        $repoUser=$this->em->getRepository(User::class);
        $pm=$repoUser->findOneBy(array('username'=>$managerName));

        $repoProject=$this->em->getRepository(Project::class);
        $projects=$repoProject->findOneBy(array('managerId'=>$pm->getId()));

        parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response
        ->andWhere('entity.projectId = :prj')
        ->setParameter('prj',$projects->getId())
        ;

        return $response;
    }      
        
    public function configureFields(string $pageName): iterable
    {
        $session=$this->requestStack->getSession();
        $managerName=$session->get('username');
        $repoUser=$this->em->getRepository(User::class);
        $pm=$repoUser->findOneBy(array('username'=>$managerName));
        $repoProject=$this->em->getRepository(Project::class);
        $repoTask = $this->em->getRepository(Task::class);

        
       

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            DateField::new('dateInit'),
            DateField::new('deadline'),
            BooleanField::new('done'),
            AssociationField::new('groupId'),
            AssociationField::new('projectId')->setQueryBuilder(
                function(QueryBuilder $qb) use ($pm){
                    return $qb
                        ->andWhere('entity.managerId = :user')
                        ->setParameter('user',$pm->getId())
                    ;
                 }),
        
        ];
    }

}
