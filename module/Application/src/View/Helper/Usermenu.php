<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
* This view helper class displays user menu
*/

class Usermenu extends AbstractHelper
{
  /**
   * Array of items.
   * @var array
   */
  private $items = [];

  /**
   * Constructor.
   * @param array $items Array of items (optional).
   */
  public function __construct($items=[])
  {
      $this->items = $items;
  }

  /**
   * Sets the items.
   * @param array $items Items.
   */
  public function setItems($items)
  {
    $this->items = $items;
  }

  /**
   * Renders the usermenu.
   * @return string HTML code of the breadcrumbs.
   */

   public function render()
   {
        if (count($this->items) == 0)
        {
            return '';
        }
        $result = '<ul class="nav navbar-nav navbar-right">';
        // Render items
        foreach ($this->items as $item) {
          if(isset($item['float']) && $item['float']=='right')
              $result .= $this->renderItem($item);
        }
        $result .= '</ul>';

        return $result;
   }

   /**
    * Renders an item.
    * @param string $label
    * @param string $link
    * @param boolean $isActive
    * @return string HTML code of the item.
    */
    protected function renderItem($item)
    {
        $id = isset($item['id']) ? $item['id'] : '';
        //$isActive = ($id==$this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        $result = '';

        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];

            $result .= '<li class="dropdown ' . /*($isActive?'active':'') .*/ '">';
            $result .= '<a href="#" class="dropdown-toggle" id="dropdownMenuButton1" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
            $result .= $escapeHtml($label) . ' <b class="caret"></b>';
            $result .= '</a>';

            $result .= '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';
            foreach ($dropdownItems as $item) {
                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';

                $result .= '<li>';
                $result .= '<a class="dropdown-item" href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
                $result .= '</li>';
            }
            $result .= '</ul>';
            $result .= '</li>';

        } else {
            $link = isset($item['link']) ? $item['link'] : '#';

            //$result .= $isActive?'<li class="active">':'<li>';
            $result .= '<a href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
            $result .= '</li>';
        }

        return $result;

      }
}
