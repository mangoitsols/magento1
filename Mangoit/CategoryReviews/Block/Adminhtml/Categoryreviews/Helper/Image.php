<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Block
 */

class Mangoit_CategoryReviews_Block_Adminhtml_Categoryreviews_Helper_Image extends Varien_Data_Form_Element_Image
{
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::getBaseUrl('media') . 'categoryreviews'. DS . $this->getValue();
        }
        return $url;
    }
}