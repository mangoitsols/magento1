<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner model
 */
class Mangoit_Custombanner_Model_Mysql4_Custombanner extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct() 
    {
        // Note that the banner_id refers to the key field in your database table.
        $this->_init('custombanner/custombanner', 'banner_id');
    }
}
