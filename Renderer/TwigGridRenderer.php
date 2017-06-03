<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\Renderer;

use Miky\Component\Grid\Definition\Action;
use Miky\Component\Grid\Definition\Field;
use Miky\Component\Grid\Definition\Filter;
use Miky\Component\Grid\FieldTypes\FieldTypeInterface;
use Miky\Component\Grid\Renderer\GridRendererInterface;
use Miky\Component\Grid\View\GridView;
use Miky\Component\Registry\ServiceRegistryInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TwigGridRenderer implements GridRendererInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $defaultTemplate;

    /**
     * @var ServiceRegistryInterface
     */
    private $fieldsRegistry;

    /**
     * @var array
     */
    private $actionTemplates;

    /**
     * @var array
     */
    private $batchActionTemplate;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var array
     */
    private $filterTemplates;

    /**
     * @var Router
     */
    private $router;

    /**
     * @param \Twig_Environment $twig
     * @param ServiceRegistryInterface $fieldsRegistry
     * @param FormFactoryInterface $formFactory
     * @param string $defaultTemplate
     * @param array $actionTemplates
     * @param array $filterTemplates
     * @param string $batchActionTemplate
     */
    public function __construct(
        \Twig_Environment $twig,
        ServiceRegistryInterface $fieldsRegistry,
        FormFactoryInterface $formFactory,
        Router $router,
        $defaultTemplate,
        array $actionTemplates = [],
        array $filterTemplates = [],
        $batchActionTemplate
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->defaultTemplate = $defaultTemplate;
        $this->fieldsRegistry = $fieldsRegistry;
        $this->actionTemplates = $actionTemplates;
        $this->formFactory = $formFactory;
        $this->filterTemplates = $filterTemplates;
        $this->batchActionTemplate = $batchActionTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function render(GridView $gridView, $template = null)
    {
        return $this->twig->render($template ?: $this->defaultTemplate, ['grid' => $gridView]);
    }

    /**
     * @param Field $field
     * @param $data
     */
    public function renderField(GridView $gridView, Field $field, $data)
    {
        /** @var FieldTypeInterface $fieldType */
        $fieldType = $this->fieldsRegistry->get($field->getType());
        $resolver = new OptionsResolver();
        $fieldType->configureOptions($resolver);
        $options = $resolver->resolve($field->getOptions());

        return $fieldType->render($field, $data, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function renderAction(GridView $gridView, Action $action, $data = null)
    {
        if (!isset($this->actionTemplates[$type = $action->getType()])) {
            throw new \InvalidArgumentException(sprintf('Missing template for action type "%s".', $type));
        }

        return $this->twig->render($this->actionTemplates[$type], [
            'grid' => $gridView,
            'action' => $action,
            'data' => $data,
        ]);
    }

    public function renderBatchActions(GridView $gridView, $data = null)
    {
        if ($this->batchActionTemplate == null) {
            throw new \InvalidArgumentException('Missing template for bulk actions.');
        }
        if (empty($gridView->getDefinition()->getBatchActions())){
            return;
        }
        $url = $this->router->generate($gridView->getRequestConfiguration()->getRouteName("batch"));
        $form = $this->formFactory->createNamed('bulk_action', 'form', [], ['required' => false, "action" => $url ]);
        $choices = array();
        foreach ($gridView->getDefinition()->getBatchActions() as $action){
            $choices[$action->getName()] = $action->getLabel();
        }
        $form->add("batchAction", ChoiceType::class,array(
            "choices" => $choices,
        ));

        return $this->twig->render($this->batchActionTemplate, [
            'grid' => $gridView,
            'form' => $form->createView(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function renderFilter(GridView $gridView, Filter $filter)
    {
        if (!isset($this->filterTemplates[$type = $filter->getType()])) {
            throw new \InvalidArgumentException(sprintf('Missing template for filter type "%s".', $type));
        }

        $form = $this->formFactory->createNamed('criteria', 'form', [], ['csrf_protection' => false, 'required' => false]);
        $form->add($filter->getName(), sprintf('miky_grid_filter_%s', $filter->getType()), $filter->getOptions());

        $criteria = $gridView->getParameters()->get('criteria', []);
        $form->submit($criteria);

        return $this->twig->render($this->filterTemplates[$type], [
            'grid' => $gridView,
            'filter' => $filter,
            'form' => $form->get($filter->getName())->createView(),
        ]);
    }
}
