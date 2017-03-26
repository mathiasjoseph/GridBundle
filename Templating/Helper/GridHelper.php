<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\GridBundle\Templating\Helper;

use Miky\Component\Grid\Definition\Action;
use Miky\Component\Grid\Definition\Field;
use Miky\Component\Grid\Definition\Filter;
use Miky\Component\Grid\Renderer\GridRendererInterface;
use Miky\Component\Grid\View\GridView;
use Symfony\Component\Templating\Helper\Helper;


class GridHelper extends Helper
{
    /**
     * @var GridRendererInterface
     */
    private $gridRenderer;

    /**
     * @param GridRendererInterface $gridRenderer
     */
    public function __construct(GridRendererInterface $gridRenderer)
    {
        $this->gridRenderer = $gridRenderer;
    }

    /**
     * @param GridView $gridView
     * @param string $template
     *
     * @return mixed
     */
    public function renderGrid(GridView $gridView, $template = null)
    {
        return $this->gridRenderer->render($gridView, $template);
    }

    /**
     * @param GridView $gridView
     * @param Field $field
     * @param mixed $data
     *
     * @return mixed
     */
    public function renderField(GridView $gridView, Field $field, $data)
    {
        return $this->gridRenderer->renderField($gridView, $field, $data);
    }

    /**
     * @param GridView $gridView
     * @param Action $action
     *
     * @return mixed
     */
    public function renderAction(GridView $gridView, Action $action, $data = null)
    {
        return $this->gridRenderer->renderAction($gridView, $action, $data);
    }

    /**
     * @param GridView $gridView
     * @param Filter $filter
     *
     * @return mixed
     */
    public function renderFilter(GridView $gridView, Filter $filter)
    {
        return $this->gridRenderer->renderFilter($gridView, $filter);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adevis_grid';
    }
}
