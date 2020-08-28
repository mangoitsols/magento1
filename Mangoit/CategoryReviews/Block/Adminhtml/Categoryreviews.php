<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom block
 */

class Mangoit_CategoryReviews_Block_Adminhtml_Categoryreviews extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_categoryreviews';
        $this->_blockGroup = 'categoryreviews';
        $this->_headerText = Mage::helper('categoryreviews')->__('Customer Reviews');
        $this->_addButtonLabel = Mage::helper('categoryreviews')->__('Add Category Review');
        parent::__construct();
    }

    public function getCategoryListing()
    {
    	return $this->setTemplate('categoryreviews/categories.phtml');
    }
}
