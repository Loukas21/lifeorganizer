<?php
namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper
{
    /**
     * Menu items array.
     * @var array
     */
    protected $items = [];

    /**
     * Active item's ID.
     * @var string
     */
    protected $activeItemId = '';

    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct($items=[])
    {
        $this->items = $items;
    }

    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId)
    {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render()
    {
        if (count($this->items)==0)
            return ''; // Do nothing if there are no items.

        /*$result = '<nav class="navbar navbar-default" role="navigation">';
        $result .= '<div class="navbar-header">';
        $result .= '<button type="button" class="navbar-toggle" data-toggle="collapse"';
        $result .= 'data-target=".navbar-ex1-collapse">';
        $result .= '<span class="sr-only">Toggle navigation</span>';
        $result .= '<span class="icon-bar"></span>';
        $result .= '<span class="icon-bar"></span>';
        $result .= '<span class="icon-bar"></span>';
        $result .= '</button>';
        $result .= '</div>';
        */

        $result = '<nav class="col-lg-2 col-md-3 flex-shrink-0 p-3 app-sidebar" role="navigation">';
        //$result .= '<div class="sidebar-header">';
        //$result .= '<button type="button" class="navbar-toggle" data-toggle="collapse"';
        //$result .= 'data-target=".navbar-ex1-collapse">';
        //$result .= '<span class="sr-only">Toggle navigation</span>';
        //$result .= '<span class="icon-bar"></span>';
        //$result .= '<span class="icon-bar"></span>';
        //$result .= '<span class="icon-bar"></span>';
        //$result .= '</button>';
        //$result .= '</div>';
        //$result .= '<a class="d-flex align-items-center pb-3 mb-3 link-light text-decoration-none border-bottom" href"/">Strona główna</a>';

        $result .= '<div class="accordion" id="accordionSidebar">';
        $result .= '<ul class="list-unstyled">';

        // Render items
        foreach ($this->items as $item) {
            if(!isset($item['float']) || $item['float']=='left')
                $result .= $this->renderItem($item);
        }

        $result .= '</ul>';
        /*
        $result .= '<ul class="nav navbar-nav navbar-right">';

        // Render items
        foreach ($this->items as $item) {
            if(isset($item['float']) && $item['float']=='right')
                $result .= $this->renderItem($item);
        }

        $result .= '</ul>';
        */
        $result .= '</div>';
        $result .= '</nav>';

        return $result;

    }

    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem($item)
    {
        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id==$this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];

            $result .= '<li class="mb-1' . ($isActive?'active':'') . '">';
            $result .= '<button href="#" class="btn collapsed app-sidebar-btn" data-bs-toggle="collapse" data-bs-target="#'.$item['id'].'-collapse" data-parent="#accordionExample" aria-expanded="true">';
            $result .= $escapeHtml($label);
            $result .= '</button>';
            $result .= '<div id="'.$item['id'].'-collapse" class="collapse" style="" data-bs-parent="#accordionSidebar">';

            $result .= '<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small app-list-group-item">';
            foreach ($dropdownItems as $item) {
                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';

                $result .= '<li class="border-bottom app-sidebar-border">';
                $result .= '<a class="'."link-light text-decoration-none px-2".'"'. 'href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
                $result .= '</li>';
            }
            $result .= '</ul>';
            $result .= '</li>';

        } else {
            $link = isset($item['link']) ? $item['link'] : '#';

            $result .= $isActive?'<li class="active">':'<li>';
            $result .= '<a class="link-light text-decoration-none" href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
            $result .= '</li>';
        }

        return $result;
    }
}
