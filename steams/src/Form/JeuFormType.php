<?php

namespace App\Form;

use App\Entity\Jeu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class JeuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, ["label" => false, 'attr' => ['placeholder' => 'Nom du Jeu', 'maxlength'=>"200"], 'required'   => true])
	    ->add('description',TextType::class, ["label" => false, 'attr' => ['placeholder' => 'Description du jeu'], 'required'   => true])
            ->add('link', TextType::class, ["label" => false, 'attr' => ['placeholder' => "Lien de téléchargement du jeu",  'maxlength'=>"200"], 'required'   => true])
            ->add('imagelink',TextType::class, ["label" => false, 'attr' => ['placeholder' => "Lien de l'image",  "maxlength"=>"200"], 'required'   => true]) 
            ->add('genre', ChoiceType::class, [
    	'choices'  => [
	"" => "",
        'FPS' => 'FPS',
        'Multiplayers' => "Multiplayers",
        'Action' => "Action",
	"Aventure" => "Aventure",
	"Combat" => "Combat",
	"Beet Them All" => "Beat Them All",
	"Tir" => "Tir",
	"Shoot Them Up" => "Shoot Them Up",
	"Jeu De Rôle" => "Jeu De Rôle",
	"Réflexion" => "Réflexion",
	"Puzzle" => "Puzzle",
	"Rythme" => "Rythme",
	"Stratégie" => "Stratégie",
	"Simulation" => "Simulation",
	"Hackn's slash" => "Hack'n slash",
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
