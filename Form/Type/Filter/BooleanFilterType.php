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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class BooleanFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => null,
                'required' => false,
                'empty_value' => 'adevis.ui.all',
                'choices' => [
                    BooleanFilter::TRUE => 'adevis.ui.yes',
                    BooleanFilter::FALSE => 'adevis.ui.no',
                ],
            ])
            ->setOptional([
                'field'
            ])
            ->setAllowedTypes([
                'field' => ['string']
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'adevis_grid_filter_boolean';
    }
}
