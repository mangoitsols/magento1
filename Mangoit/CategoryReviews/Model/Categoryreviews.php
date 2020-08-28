<?php
/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Model
 */

class Mangoit_CategoryReviews_Model_Categoryreviews extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('categoryreviews/categoryreviews');
    }
}