<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner group collection
 */
class Mangoit_Custombanner_Model_Mysql4_Custombannergroup_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    /**
     * Constructor class
     */
    public function _construct() 
    {
        parent::_construct();
        $this->_init('custombanner/custombannergroup');
    }

    /**
     * Get duplicate banner group code
     */
    public function getDuplicateGroupCode($groupCode) 
    {
        $this->setConnection($this->getResource()->getReadConnection());
        $model = Mage::getModel('custombanner/custombannergroup')->getCollection()
            ->addFieldToSelect('group_id')
            ->addFieldToFilter('group_code', $groupCode);
        return $model;
    }
}
