<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner group model
 */
class Mangoit_Custombanner_Model_Mysql4_Custombannergroup extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Constructor class
     */
    public function _construct() 
    {
        $this->_init('custombanner/custombannergroup', 'group_id');
    }

    /**
     * Check group code is not blank before saving custom banner group
     */
    public function _beforeSave(Mage_Core_Model_Abstract $object) 
    {
        $isDataValid = true;
        $id = $object->getId();
        $groupCode = $object->getGroupCode();
        $groupCollection = Mage::getModel('custombanner/custombannergroup')->getCollection();
        if ($id == '' || $id == 0) {
            if ($groupCode == '') {
                Mage::throwException('Custombanner Group code can\'t be blank !!');
            } else {
                $groupInfo = $groupCollection->getDuplicateGroupCode($groupCode);
                if ($groupInfo->count() > 0) {
                    $isDataValid = false;
                }
                
                if ($isDataValid === false) {
                    Mage::throwException("Custombanner Group Code already exists !!");
                }
            }
        }
    }

}
