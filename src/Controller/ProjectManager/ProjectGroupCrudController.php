<?php
/**
 * @author Mohammed MOQRAN 
 */
namespace App\Controller\ProjectManager;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\ProjectGroup;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectGroupCrudController extends AbstractCrudController
{
    private $em,$requestStack;
    public function __construct(EntityManagerInterface $em,RequestStack $requestStack)
    {
        $this->em=$em;
        $this->requestStack = $requestStack;
    }
    
    public static function getEntityFqcn(): string
    {
        return ProjectGroup::class;
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
            ->andWhere('entity.idProject = :prj')
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
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('idGroup'),
            AssociationField::new('idProject')->setQueryBuilder(
                function(QueryBuilder $qb) use ($pm){
                    return $qb
                        ->andWhere('entity.managerId = :user')
                        ->setParameter('user',$pm->getId())
                    ;
                 }),

            
        ];
    }
    
}
