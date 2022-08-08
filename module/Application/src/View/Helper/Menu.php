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

        // if sidebar menu has no options
        if (count($this->items)==0)
            return ''; // Do nothing if there are no items.

        // open <nav> tag and style it
        $result = '<nav class="col-lg-2 col-md-3 flex-shrink-0 p-3 app-sidebar" role="navigation">';
        // add accordion element
        $result .= '<div class="accordion" id="accordionSidebar">';
        // open unordered list tag
        $result .= '<ul class="list-unstyled">';

        // Render items
        foreach ($this->items as $item) {
            if(!isset($item['float']) || $item['float']=='left')
                $result .= $this->renderItem($item);
        }
        // close unordered list tag
        $result .= '</ul>';
        // close accordion element
        $result .= '</div>';
        // close <nav> tag
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
        //echo $this->activeItemId;
        //echo $item['id'];
        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];
            $dropdownString = "";
            $activeDropdown = "";
            foreach ($dropdownItems as $dropdownItem) {
                $link = isset($dropdownItem['link']) ? $dropdownItem['link'] : '#';
                $dropdownLabel = isset($dropdownItem['label']) ? $dropdownItem['label'] : '';

                //$result .= '<li class="border-bottom app-sidebar-border">';
                //$result .= '<a class="'."text-decoration-none px-2";
                if ($this->activeItemId == $dropdownItem['id']){
                  $dropdownString .= '<li class="app-sidebar-border app-sidebar-active-element">';
                  $dropdownString .= '<a class="text-decoration-none px-2 link-light app-sidebar-menu-link active"';
                  $activeDropdown = $item['id'];
                }
                else {
                  $dropdownString .= '<li class="app-sidebar-border">';
                  $dropdownString .= '<a class="text-decoration-none px-2 link-light app-sidebar-menu-link"';
                }
                $dropdownString .= ' href="'.$escapeHtml($link).'">'.$escapeHtml($dropdownLabel).'</a>';
                $dropdownString .= '</li>';
            }

            if ($activeDropdown == $item['id']) {
                $result .= '<li class="mb-0 active">';
                $result .= '<button href="#" class="btn app-sidebar-btn" data-bs-toggle="collapse" data-bs-target="#'.$item['id'].'-collapse" data-parent="#accordionExample" aria-expanded="true">';
                $result .= $escapeHtml($label);
                $result .= '</button>';
                $result .= '<div id="'.$item['id'].'-collapse" class="collapse show" style="" data-bs-parent="#accordionSidebar">';
            }
            else {
              $result .= '<li class="mb-0">';
              $result .= '<button href="#" class="btn collapsed app-sidebar-btn" data-bs-toggle="collapse" data-bs-target="#'.$item['id'].'-collapse" data-parent="#accordionExample" aria-expanded="false">';
              $result .= $escapeHtml($label);
              $result .= '</button>';
              $result .= '<div id="'.$item['id'].'-collapse" class="collapse" style="" data-bs-parent="#accordionSidebar">';
            }

            $result .= '<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small app-list-group-item">';
            $result .= $dropdownString;

            $result .= '</ul>';
            $result .= '</li>';

        } else {
            $link = isset($item['link']) ? $item['link'] : '#';

            $result .= $isActive?'<li class="px-1 active app-sidebar-active-element">':'<li class="px-1">';
            $result .= '<a class="link-light app-sidebar-menu-link text-decoration-none" href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
            $result .= '</li>';
        }

        return $result;
    }
}
