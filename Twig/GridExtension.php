<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\Twig;

use Miky\Bundle\GridBundle\Templating\Helper\GridHelper;
use Miky\Component\Grid\Definition\Action;
use Miky\Component\Grid\Definition\Field;
use Miky\Component\Grid\Definition\Filter;
use Miky\Component\Grid\View\GridView;


class GridExtension extends \Twig_Extension
{
    /**
     * @var GridHelper
     */
    private $gridHelper;

    /**
     * @param GridHelper $gridHelper
     */
    public function __construct(GridHelper $gridHelper)
    {
        $this->gridHelper = $gridHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('miky_grid_render', [$this, 'renderGrid'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('miky_grid_render_field', [$this, 'renderField'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('miky_grid_render_action', [$this, 'renderAction'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('miky_grid_render_filter', [$this, 'renderFilter'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('miky_grid_render_batch_action', [$this, 'renderBatchActions'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param GridView $gridView
     * @param string $template
     * @param array $variables
     *
     * @return mixed
     */
    public function renderGrid(GridView $gridView, $template = null)
    {
        return $this->gridHelper->renderGrid($gridView, $template);
    }

    /**
     * @param Field $field
     * @param GridView $gridView
     * @param mixed $data
     *
     * @return mixed
     */
    public function renderField(GridView $gridView, Field $field, $data)
    {
        return $this->gridHelper->renderField($gridView, $field, $data);
    }

    /**
     * @param GridView $gridView
     * @param Action $action
     * @param mixed $data
     */
    public function renderAction(GridView $gridView, Action $action, $data = null)
    {
        return $this->gridHelper->renderAction($gridView, $action, $data);
    }

    /**
     * @param GridView $gridView
     * @param mixed $data
     */
    public function renderBatchActions(GridView $gridView, $data = null)
    {
        return $this->gridHelper->renderBatchAction($gridView, $data);
    }

    /**
     * @param GridView $gridView
     * @param Action $action
     * @param mixed $data
     */
    public function renderFilter(GridView $gridView, Filter $filter)
    {
        return $this->gridHelper->renderFilter($gridView, $filter);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'miky_grid';
    }
}
