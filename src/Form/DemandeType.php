<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Status;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true
            ])
            ->add('contenu',TextType::class, [
                'required' => true
            ])
            ->add('piece_jointe', FileType::class, [
                'label' => 'Piece jointe',
                'mapped' => false,
                'required' => true,
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC')
                        ->setMaxResults(1);
                },
                'choice_label' => 'nom',
            ]) ->add('submit', SubmitType::class, [
                'label' => "Valider ma demande",
                'attr' => [
                    'class' => 'btn btn-info'
                ]
            ]);;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
