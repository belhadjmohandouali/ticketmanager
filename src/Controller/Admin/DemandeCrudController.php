<?php

namespace App\Controller\Admin;

use App\Entity\Demande;
use App\Entity\Status;
use App\Entity\User;
use App\Service\StatusManagerService;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class DemandeCrudController extends AbstractCrudController
{
    public function __construct(ManagerRegistry $entitymanager)
    {
        $this->entitymanager = $entitymanager;
    }
    public static function getEntityFqcn(): string
    {
        return Demande::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $status = $this->entitymanager->getRepository(Status::class)->findOneBy(['id'=>1]);
        $action = $this->getContext()->getCrud()->getCurrentAction();

        $render = [];
        switch ($action){
           case "new":
               $render = [
                   TextField::new('titre'),
                   TextEditorField::new('contenu'),
                   ChoiceField::new('status')->setChoices([
                       $status->getNom() => $status
                   ])
               ];
               break;

            case "index":
                $render = [
                    IdField::new('id'),
                    TextField::new('titre'),
                    TextEditorField::new('contenu'),
                    TextField::new('status'),
                    TextField::new('user.email', 'Créée par')

                ];
                break;

            case "edit":
                $statusDemande = $this->getContext()->getEntity()->getInstance()->getStatus()->getId();
                $statusManager = new statusManagerService();
                $status = $statusManager->calculStatusEdit($statusDemande,$this->entitymanager);

                $render = [
                    IdField::new('id')->setFormTypeOption('disabled','disabled'),
                    TextField::new('titre'),
                    TextEditorField::new('contenu'),
                    ChoiceField::new('status')->setChoices($status),
                    TextField::new('user.email', 'Créée par')->setFormTypeOption('disabled','disabled'),
                ];
                break;

        }


        return $render;
    }

}
