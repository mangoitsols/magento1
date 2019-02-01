<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner model
 */
class Mangoit_Custombanner_Model_Custombannergroup extends Mage_Core_Model_Abstract
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
     * Get banner data with banner group code
     */
    public function getDataByGroupCode($groupCode) 
    {        
        $groupData = array();
        $bannerData = array();
        $result = array('group_data'=>$groupData,'banner_data'=>$bannerData);
        $model = Mage::getModel('custombanner/custombannergroup')->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('group_code', $groupCode);
        foreach ($model as $record) {
            $bannerIds = $record->getBannerIds();
            $bannerModel = Mage::getModel('custombanner/custombanner');
            $bannerData = $bannerModel->getDataByBannerIds($bannerIds);
            $result = array('group_data' => $record, 'banner_data' => $bannerData);
        }

        return $result;
    }
}

