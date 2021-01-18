<?php

namespace App\Form;

use App\Entity\AffectationCompetences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Ressources;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AffectationCompetenceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ressource',EntityType::class,['label'=>'Ressource : ','attr'=>['class'=>'form-control'],
                // Recherche des choix de cette entité
                'class' => Ressources::class,
                // utilise la propriété Ressources.NomPrenom comme chaîne d'options visible
                'choice_label' => 'NomPrenom'
               ])
            ->add('competence',ChoiceType::class,['label'=>'Compétences','choices'=>
            ['homologation'=>'homologation','PHP'=>'PHP','J2EE'=>'J2EE','.Net'=>'.Net','C#'=>'C#','JavaScript'=>'JavaScript'],'attr'=>['class'=>'form-control']])
            ->add('niveau',ChoiceType::class,['label'=>'Niveau','choices'=>
            ['Débutant'=>'Débutant','Junior '=>'junior','Confirmé'=>'confirmé','Sénior'=>'sénior','Expert'=>'expert'],'attr'=>['class'=>'form-control']])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AffectationCompetences::class,
        ]);
    }
}
