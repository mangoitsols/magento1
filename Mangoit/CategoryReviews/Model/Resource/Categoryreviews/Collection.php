<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Model
 */

class Mangoit_CategoryReviews_Model_Resource_Categoryreviews_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('categoryreviews/categoryreviews');
    }
}