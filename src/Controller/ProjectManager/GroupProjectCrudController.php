<?php
/**
 * @author Mohammed MOQRAN 
 */
namespace App\Controller\ProjectManager;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Project;
use App\Entity\GroupProject;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GroupProjectCrudController extends AbstractCrudController
{

    private $em,$requestStack;
    public function __construct(EntityManagerInterface $em,RequestStack $requestStack)
    {
        $this->em=$em;
        $this->requestStack = $requestStack;
    }
    public static function getEntityFqcn(): string
    {
        return GroupProject::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $session=$this->requestStack->getSession();
        $managerName=$session->get('username');
        $repoUser=$this->em->getRepository(User::class);
        $pm=$repoUser->findOneBy(array('username'=>$managerName));
        return [
            IdField::new('id')->hideOnForm(),
            
            IdField::new('idGroup'),
            IDField::new('idProject')/*->setQueryBuilder(
                function(QueryBuilder $qb) use ($pm){
                    return $qb
                        ->andWhere('entity.managerId = :user')
                        ->setParameter('user',$pm->getId())
                    ;
                 })*/,
        ];
    }
    
}
