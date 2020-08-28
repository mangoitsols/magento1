<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Block
 */

class Mangoit_CategoryReviews_Block_Customcategoryreviews extends Mage_Core_Block_Template
{
	public function getCategoryReviewsData($catId)
	{
		$reviews = [];
		$model = Mage::getModel('categoryreviews/categoryreviews')->getCollection()
					->addFieldToSelect('*')
			        ->addFieldToFilter('category_id',array('like' => '%'.$catId.'%'))
			        ->setOrder('created_at', 'desc')
			        ->load();

		$reviews = $model->getData();
		return $reviews;
	}

	public function getParentCustomAttributeData($catIds, $attributeCode)
	{
		if (isset($catIds[3]) && isset($catIds[4])) {
    		if (!$attribute) {
				$parentCatId = $catIds[4];
	            $_parent_cat = Mage::getModel('catalog/category')->load((int)$parentCatId);
	            $attribute = $_parent_cat->$attributeCode();
    		}    		
    	}
    	return $attribute;
	}
}