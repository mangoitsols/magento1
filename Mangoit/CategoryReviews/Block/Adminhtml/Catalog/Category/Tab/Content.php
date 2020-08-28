<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Block
 */

class Mangoit_CategoryReviews_Block_Adminhtml_Catalog_Category_Tab_Content extends Mage_Adminhtml_Block_Catalog_Form
{
	public function __construct()
	{
		echo Mage::registry('current_category');
	}

	/**
     * Get current category
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        return Mage::registry('current_category');
    }
}