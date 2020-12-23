<?php

namespace App\Form;

use App\Entity\Jeu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class JeuSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$builder
	->add('description', TextType::class, ["label" => false, 'attr' => ['placeholder' => 'Mot clé'], 'required' => false])
	 ->add('genre', ChoiceType::class, ['required' => false,
	"label" => false,
        'choices'  => [
        "" => "",
        'FPS' => 'FPS',
        'Multiplayers' => "Multiplayers",
        'Action' => "Action",
        "Aventure" => "Aventure",
        "Combat" => "Combat",
        "Beat Them All" => "Beat Them All",
        "Tir" => "Tir",
        "Shoot Them Up" => "Shoot Them Up",
        "Jeu De Rôle" => "Jeu De Rôle",
        "Réflexion" => "Réflexion",
        "Puzzle" => "Puzzle",
        "Rythme" => "Rythme",
        "Stratégie" => "Stratégie",
        "Simulation" => "Simulation",
        "Hack 'n' slash" => "Hack 'n' slash",
        "Labyrinthe" => "Labyrinthe",
        "Visual Novel" => "Visual novel",
        "Infiltration" => "Infiltration",
        "Rail Shooter" => "Rail Shooter",
        "Plateforme" => "Plateforme",
        "Tir en vue subjective" => "Tir en vue subjective"
        ],
        ])
	;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
