<?php

namespace App\Form;

use App\Entity\AffectationRessources;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Ressources;
use App\Entity\Projets;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class AffectationRessourcesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('Ressource',EntityType::class,['label'=>'Ressource : ','attr'=>['class'=>'form-control'],
                                                 // Recherche des choix de cette entité
                                                    'class' => Ressources::class,
                                                    // utilise la propriété Ressources.NomPrenom comme chaîne d'options visible
                                                    'choice_label' => 'NomPrenom'
                                                ])
            /*->add('Projet',EntityType::class,[ 
                                                'label'=>'Projet : ','attr'=>['class'=>'form-control'],
                                            // Recherche des choix de cette entité
                                        'class' => Projets::class,
                                        // utilise la propriété Projets.nomProjet comme chaîne d'options visible
                                        'choice_label' => 'nomProjet'])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AffectationRessources::class,
        ]);
    }
}
