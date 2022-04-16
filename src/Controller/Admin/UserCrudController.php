<?php
/**
* @author Sami DAHMANI
*/
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName) : iterable
    {
        $password = TextField::new('encpassword')->hideOnIndex();
        if (Crud::PAGE_EDIT === $pageName) {
            $password22= $password;
            $password = TextField::new('password2')->hideOnIndex();

        }
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('prenom'),
            $password
            ,
            ChoiceField::new('roles')
            ->autocomplete()
            ->allowMultipleChoices()
            ->setChoices([  'Membre' => 'ROLE_MEMBER',
                            'Admin' => 'ROLE_ADMIN',
                            'Chef de Projet' => 'ROLE_PROJECT_CHEF',
                            'Chef Equipe' => 'ROLE_EQUIPE_CHEF' ]
        ),
            AssociationField::new('groupId'),

            AssociationField::new('projects')


        ];
    

    }
}


