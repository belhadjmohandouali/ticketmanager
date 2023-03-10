<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $render = [];
        $action = $this->getContext()->getCrud()->getCurrentAction();
        switch ($action){
            case "new":
                $render = [
                    IdField::new('id'),
                    TextField::new('email'),
                    TextEditorField::new('password'),
                    ChoiceField::new('roles')->setChoices(
                        [
                            'Admin' => '["ROLE_ADMIN"]',
                            'User' => '["ROLE_USER"]',
                        ]
                    )->allowMultipleChoices()
                ];
                break;

            case "index":
                $render = [
                    IdField::new('id'),
                    TextField::new('email'),
                    //TextEditorField::new('password'),
                   // TextField::new('roles')->setValue(''),

                ];
                break;

            case "edit":
                $render = [
                    IdField::new('id')->setFormTypeOption('disabled','disabled'),
                    TextField::new('email'),
                    TextEditorField::new('password'),
                    ChoiceField::new('roles')->setChoices(
                        [
                            'Admin' => '["ROLE_ADMIN"]',
                            'User' => '["ROLE_USER"]',
                        ]
                    )->allowMultipleChoices()
                ];
                break;

        }


        return $render;
    }

}
