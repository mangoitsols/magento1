<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Show tab in custom banner group 
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setId('custombannergroup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('custombanner')->__('Custom Banner Group Information'));
    }

    /**
     * Add tab in custom banner group tab
     */
    protected function _beforeToHtml() 
    {
        $this->addTab(
            'form_section', array(
            'label' => Mage::helper('custombanner')->__('Custombanner Group'),
            'alt' => Mage::helper('custombanner')->__('Custombanner Group'),
            'content' => $this->getLayout()->createBlock('custombanner/adminhtml_custombannergroup_edit_tab_form')->toHtml(),
            )
        );

        $this->addTab(
            'grid_section', array(
            'label' => Mage::helper('custombanner')->__('Banners'),
            'alt' => Mage::helper('custombanner')->__('Banners'),
            'content' => $this->getLayout()->createBlock('custombanner/adminhtml_custombannergroup_edit_tab_gridbanner')->toHtml(),
            )
        );

        return parent::_beforeToHtml();
    }
}
