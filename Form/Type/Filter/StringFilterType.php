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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('type', ChoiceType::class, [
                'choices' => [
                    StringFilter::TYPE_CONTAINS => 'miky_core.contains',
                    StringFilter::TYPE_NOT_CONTAINS => 'miky_core.not_contains',
                    StringFilter::TYPE_EQUAL => 'miky_core.equal',
                    StringFilter::TYPE_EMPTY => 'miky_core.empty',
                    StringFilter::TYPE_NOT_EMPTY => 'miky_core.not_empty',
                    StringFilter::TYPE_STARTS_WITH => 'miky_core.starts_with',
                    StringFilter::TYPE_ENDS_WITH => 'miky_core.ends_with',
                    StringFilter::TYPE_IN => 'miky_core.in',
                    StringFilter::TYPE_NOT_IN => 'miky_core.not_in'
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
        return 'miky_grid_filter_string';
    }
}
