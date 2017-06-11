<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04/06/17
 * Time: 14:22
 */

namespace Miky\Bundle\GridBundle\Form\Factory;


use Miky\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Miky\Component\Grid\Definition\Grid;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormFactoryInterface;

class BatchActionFormFactory
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Router
     */
    private $router;

    /**
     * FormFactory constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory, Router $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }
    /**
     * {@inheritdoc}
     */
    public function createForm(Grid $grid, RequestConfiguration $requestConfiguration, array $options = array())
    {
        $url = $this->router->generate($requestConfiguration->getRouteName("batch"));
        $form = $this->formFactory->createNamed('batch_action', 'form', [], ['required' => false, "action" => $url, 'attr' => ['id' => 'batch_action'] ]);
        $choices = array();
        $choices["miky_grid.batch_actions"] = null;
        foreach ($grid->getBatchActions() as $action){
            $choices[$action->getLabel()] = $action->getName();
        }
        $form->add("batchAction", ChoiceType::class,array(
            "choices" => $choices,
        ));
        return $form;
    }
}