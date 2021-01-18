<?php

namespace App\Form;

use App\Entity\Projets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class ProjetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProjet',TextType::class,['label'=>'Nom de projet ','attr'=>['class'=>'form-control']])
            ->add('priorite',ChoiceType::class,['label'=>'Priorité du projet ','attr'=>['class'=>'form-control'],
                                              'choices'=>['critique'=>'critique','moyenne'=>'moyenne','normale'=>'normale']])
           
            ->add('nombreRessorces',NumberType::class,['label'=>'Le nombre de ressources ','attr'=>['class'=>'form-control']])
            ->add('niveau_competences',ChoiceType::class,['label'=>'Niveau de compétence  ','attr'=>['class'=>'form-control'],
                                                        'choices'=>['Débutant'=>'Débutant','Junior '=>'Junior','Confirmé'=>'Confirmé','Sénior'=>'Sénior','Expert'=>'Expert']])
            ->add('etat',HiddenType::class,['label'=>false,'attr'=>['value'=>'Activé']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projets::class,
        ]);
    }
}
