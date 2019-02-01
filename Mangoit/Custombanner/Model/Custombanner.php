<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner model
 */
class Mangoit_Custombanner_Model_Custombanner extends Mage_Core_Model_Abstract
{

    public function _construct() 
    {
        parent::_construct();
        $this->_init('custombanner/custombanner');
    }

    /**
     * Get all available custom  banner ids
     */
    public function getAllAvailBannerIds()
    {
        $collection = Mage::getResourceModel('custombanner/custombanner_collection')
                        ->getAllIds();
        return $collection;
    }

    /**
     * Get all custom banner collection
     */
    public function getAllBanners() 
    {
        $model = Mage::getModel('custombanner/custombanner')->getCollection()
                ->addFieldToFilter('status', 1);
        $data = array();
        foreach ($collection as $record) {
            $data[$record->getId()] = array('value' => $record->getId(), 'label' => $record->getfilename());
        }

        return $data;
    }

    /**
     * Get custom banner data with custom banner id
     */
    public function getDataByBannerIds($bannerIds) 
    {
        $data = array();
        if ($bannerIds != '') {
            $model = Mage::getModel('custombanner/custombanner')->getCollection()
                ->addFieldToFilter('banner_id', array('in' => explode(',', $bannerIds)))
                ->setOrder('sort_order');

            foreach ($model as $record) {
                $status = $record->getStatus();
                if ($status == 1) {
                    $data[] = $record;
                }
            }
        }

        return $data;
    }
}
