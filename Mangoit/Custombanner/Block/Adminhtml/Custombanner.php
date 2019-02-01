<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Initialize custom banner block
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombanner extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        $this->_controller = 'adminhtml_custombanner';
        $this->_blockGroup = 'custombanner';
        $this->_headerText = Mage::helper('custombanner')->__('Custom Banner Manager');
        $this->_addButtonLabel = Mage::helper('custombanner')->__('Add Custom Banner Item');
        parent::__construct();
    }
}
