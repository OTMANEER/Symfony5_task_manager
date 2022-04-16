<?php

/**
    * @author Mohammed MOQRAN
    */
namespace App\Form;

use App\Entity\Task;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    // private $em,$twig,$request;
    // public function __construct(EntityManagerInterface $em,Environment $twig,Request $request)
    // {
    //     $this->em=$em;
    //     $this->request=$request;
    //     $this->twig=$twig;
        
    // }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $parametersToValidate = $this->request->query->all();
        // $repoProject=$this->em->getRepository(Project::class);
        // $prj=$repoProject->findBy(array('id'=>$parametersToValidate['prjID']));
        $builder
            ->add('title')
            ->add('description')
            ->add('done')
            ->add('dateInit')
            ->add('deadline')
            ->add('dateFin')
            ->add('groupId')
            ->add('projectId')
            ->add('userId')
            ->add('Submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(array(
            'prj',
        ));
    
        $resolver->setDefaults(array(
            'prj' => null,
        ));
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}