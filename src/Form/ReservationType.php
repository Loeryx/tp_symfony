<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Table;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reservationDate', null, [
                'widget' => 'single_text',
                'label' => 'Reservation Date'
            ]);

        if ($options['include_table']) {
            $builder->add('reservedTable', EntityType::class, [
                'class' => Table::class,
                'choice_label' => 'id',
                'label' => 'Table'
            ]);
        }

        if ($options['include_customer']) {
            $builder->add('customer', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'lastName',
                'label' => 'Customer'
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'include_table' => true,
            'include_customer' => true,
        ]);
    }
}
