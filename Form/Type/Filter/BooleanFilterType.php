<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\Form\Type\Filter;

use Miky\Component\Grid\Filter\BooleanFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class BooleanFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

            $builder->add('value', ChoiceType::class, array(
        'data_class' => null,
        'required' => false,
        'placeholder' => 'miky_core.all',
        'choices' => [
            'miky_core.yes' => BooleanFilter::TRUE,
            'miky_core.no' => BooleanFilter::FALSE
        ],
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'miky_grid_filter_boolean';
    }
}
