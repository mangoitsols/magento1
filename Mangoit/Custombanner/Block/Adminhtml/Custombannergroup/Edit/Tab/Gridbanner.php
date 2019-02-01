<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Show banner grid in custom banner group form
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup_Edit_Tab_Gridbanner extends Mage_Adminhtml_Block_Widget_Container
{

    /**
     * Set template
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setTemplate('custombanner/banners.phtml');
    }

    public function getTabsHtml() 
    {
        return $this->getChildHtml('tabs');
    }

    /**
     * Prepare button and grid
     */
    protected function _prepareLayout() 
    {
        $this->setChild('tabs', $this->getLayout()->createBlock('custombanner/adminhtml_custombannergroup_edit_tab_custombanner', 'custombannergroup.grid.custombanner'));
        return parent::_prepareLayout();
    }
    
    /**
     * Get banner group data
     */
    public function getBannergroupData() 
    {
        return Mage::registry('custombannergroup_data');
    }
    /**
     * Get banner data to show in banner grid of custom banner group form
     */
    public function getBannersJson() 
    {
        $banners = explode(',', $this->getBannergroupData()->getBannerIds());
        if (!empty($banners) && isset($banners[0]) && $banners[0] != '') {
            $data = array();
            foreach ($banners as $element) {
                $data[$element] = $element;
            }

            return Zend_Json::encode($data);
        }
        
        return '{}';
    }
}