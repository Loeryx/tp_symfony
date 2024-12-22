<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Enum\RestaurantCategoryEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('phone')
            ->add('category', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($enum) => $enum->value, RestaurantCategoryEnum::cases()),
                    RestaurantCategoryEnum::cases()
                ),
                'expanded' => false,
                'multiple' => false,
                'label' => 'Category',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
