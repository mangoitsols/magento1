<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Block
 */

class Mangoit_CategoryReviews_Block_Adminhtml_Categoryreviews_Widget_Grid_Column_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
	    $img = $row->getData($this->getColumn()->getIndex());
	    if ($img && strpos($img, 'no_selection') !== 0) {
	        return sprintf('<img src="%s" width="60px" />', Mage::getBaseUrl('media') . 'categoryreviews'. DS . $img);
	    }
	    return '';
	}   
}