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

use Miky\Component\Grid\Filter\StringFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class StringFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                'choices' => [
                    StringFilter::TYPE_CONTAINS => 'adevis.ui.contains',
                    StringFilter::TYPE_NOT_CONTAINS => 'adevis.ui.not_contains',
                    StringFilter::TYPE_EQUAL => 'adevis.ui.equal',
                    StringFilter::TYPE_EMPTY => 'adevis.ui.empty',
                    StringFilter::TYPE_NOT_EMPTY => 'adevis.ui.not_empty',
                    StringFilter::TYPE_STARTS_WITH => 'adevis.ui.starts_with',
                    StringFilter::TYPE_ENDS_WITH => 'adevis.ui.ends_with',
                    StringFilter::TYPE_IN => 'adevis.ui.in',
                    StringFilter::TYPE_NOT_IN => 'adevis.ui.not_in'
                ]
            ])
            ->add('value', 'text', ['required' => false])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => null
            ])
            ->setOptional([
                'fields'
            ])
            ->setAllowedTypes([
                'fields' => ['array']
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'adevis_grid_filter_string';
    }
}