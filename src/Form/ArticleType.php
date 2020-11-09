<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'aaaabbb ffsdfsdf'],
                'empty_data' => 'John Doe',
                'required' => false,
                'row_attr' => ['class' => 'zzzzzzz', 'id' => 'qqq'],
            ])
            ->add('content', TextareaType::class, [])
            ->add('image', TextType::class, [])
            ->add('field', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('attending', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'yes' => true,
                    'no' => false,
                    'maybe' => null,
                ]]
            )
            ->add('categories', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'title',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Article'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'validation_groups' => ["Default"]
        ]);
    }
}
