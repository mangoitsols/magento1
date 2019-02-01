<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner collection
 */
class Mangoit_Custombanner_Model_Mysql4_Custombanner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct() 
    {
        parent::_construct();
        $this->_init('custombanner/custombanner');
    }

}
