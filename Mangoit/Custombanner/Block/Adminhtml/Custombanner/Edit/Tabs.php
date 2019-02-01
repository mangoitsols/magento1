<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Add tab in the custom banner form
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombanner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setId('banner_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('custombanner')->__('Banner Information'));
    }

    /**
     * Add tab in custom banner add/edit form
     */
    protected function _beforeToHtml() 
    {
        $this->addTab(
            'form_section', array(
            'label' => Mage::helper('custombanner')->__('Custom Banner Information'),
            'alt' => Mage::helper('custombanner')->__('Custom Banner Information'),
            'content' => $this->getLayout()->createBlock('custombanner/adminhtml_custombanner_edit_tab_form')->toHtml(),
            )
        );        
        return parent::_beforeToHtml();
    }
}
